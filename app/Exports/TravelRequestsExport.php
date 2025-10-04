<?php

namespace App\Exports;

use App\Models\TravelRequest;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class TravelRequestsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = TravelRequest::query()->with(['user', 'approver']);

        if (isset($this->filters['status']) && $this->filters['status']) {
            $query->where('status', $this->filters['status']);
        }

        if (isset($this->filters['start_date']) && $this->filters['start_date']) {
            $query->where('start_date', '>=', $this->filters['start_date']);
        }

        if (isset($this->filters['end_date']) && $this->filters['end_date']) {
            $query->where('end_date', '<=', $this->filters['end_date']);
        }

        if (isset($this->filters['user_id']) && $this->filters['user_id']) {
            $query->where('user_id', $this->filters['user_id']);
        }

        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'ID',
            'User Name',
            'NIK',
            'Purpose',
            'Destination',
            'Start Date',
            'End Date',
            'Budget (IDR)',
            'Status',
            'Notes',
            'Approved By',
            'Approved At',
            'Created At',
        ];
    }

    public function map($request): array
    {
        return [
            $request->id,
            $request->user->name,
            $request->user->nik,
            $request->purpose,
            $request->destination,
            $request->start_date ? $request->start_date->format('Y-m-d') : '',
            $request->end_date ? $request->end_date->format('Y-m-d') : '',
            number_format($request->budget, 2, ',', '.'),
            ucfirst($request->status),
            $request->notes,
            $request->approver ? $request->approver->name : '',
            $request->approved_at ? $request->approved_at->format('Y-m-d H:i:s') : '',
            $request->created_at->format('Y-m-d H:i:s'),
        ];
    }
}