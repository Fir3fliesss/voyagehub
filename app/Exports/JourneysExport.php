<?php

namespace App\Exports;

use App\Models\Journey;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class JourneysExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Journey::query()->with('user');

        if (!empty($this->filters['start_date'])) {
            $query->where('start_date', '>=', $this->filters['start_date']);
        }

        if (!empty($this->filters['end_date'])) {
            $query->where('end_date', '<=', $this->filters['end_date']);
        }

        if (!empty($this->filters['user_id'])) {
            $query->where('user_id', $this->filters['user_id']);
        }

        if (!empty($this->filters['destination'])) {
            $query->where('destination', 'like', '%' . $this->filters['destination'] . '%');
        }

        return $query->orderBy('start_date', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'User Name',
            'NIK',
            'Title',
            'Destination',
            'Start Date',
            'End Date',
            'Transport',
            'Accommodation',
            'Budget (IDR)',
            'Notes',
            'Created At',
        ];
    }

    public function map($journey): array
    {
        return [
            $journey->id,
            $journey->user->name,
            $journey->user->nik,
            $journey->title,
            $journey->destination,
            $journey->start_date ? $journey->start_date->format('Y-m-d') : '',
            $journey->end_date ? $journey->end_date->format('Y-m-d') : '',
            $journey->transport,
            $journey->accommodation,
            number_format($journey->budget, 2, ',', '.'),
            $journey->notes,
            $journey->created_at->format('Y-m-d H:i:s'),
        ];
    }
}