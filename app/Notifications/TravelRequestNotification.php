<?php

namespace App\Notifications;

use App\Models\TravelRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TravelRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $travelRequest;
    protected $action;
    protected $actionBy;

    public function __construct(TravelRequest $travelRequest, string $action, $actionBy = null)
    {
        $this->travelRequest = $travelRequest;
        $this->action = $action; // 'submitted', 'approved', 'rejected'
        $this->actionBy = $actionBy;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $mailMessage = new MailMessage();

        switch ($this->action) {
            case 'submitted':
                return $mailMessage
                    ->subject('New Travel Request Submitted')
                    ->greeting('Hello Admin,')
                    ->line('A new travel request has been submitted by ' . $this->travelRequest->user->name)
                    ->line('**Purpose:** ' . $this->travelRequest->purpose)
                    ->line('**Destination:** ' . $this->travelRequest->destination)
                    ->line('**Travel Dates:** ' . $this->travelRequest->start_date->format('M d, Y') . ' - ' . $this->travelRequest->end_date->format('M d, Y'))
                    ->line('**Budget:** Rp ' . number_format($this->travelRequest->budget, 0, ',', '.'))
                    ->action('Review Request', route('admin.travel-requests.show', $this->travelRequest))
                    ->line('Please review and approve/reject this request.');

            case 'approved':
                return $mailMessage
                    ->subject('Travel Request Approved')
                    ->greeting('Hello ' . $this->travelRequest->user->name . ',')
                    ->line('Good news! Your travel request has been approved.')
                    ->line('**Purpose:** ' . $this->travelRequest->purpose)
                    ->line('**Destination:** ' . $this->travelRequest->destination)
                    ->line('**Travel Dates:** ' . $this->travelRequest->start_date->format('M d, Y') . ' - ' . $this->travelRequest->end_date->format('M d, Y'))
                    ->line('**Approved by:** ' . ($this->actionBy ? $this->actionBy->name : 'Admin'))
                    ->action('View Details', route('travel-requests.show', $this->travelRequest))
                    ->line('You can now proceed with your travel preparations.');

            case 'rejected':
                return $mailMessage
                    ->subject('Travel Request Rejected')
                    ->greeting('Hello ' . $this->travelRequest->user->name . ',')
                    ->line('Unfortunately, your travel request has been rejected.')
                    ->line('**Purpose:** ' . $this->travelRequest->purpose)
                    ->line('**Destination:** ' . $this->travelRequest->destination)
                    ->line('**Rejected by:** ' . ($this->actionBy ? $this->actionBy->name : 'Admin'))
                    ->line('**Reason:** ' . $this->travelRequest->notes)
                    ->action('View Details', route('travel-requests.show', $this->travelRequest))
                    ->line('Please contact your administrator if you have any questions.');

            default:
                return $mailMessage
                    ->subject('Travel Request Update')
                    ->line('Your travel request status has been updated.');
        }
    }

    public function toArray($notifiable)
    {
        $data = [
            'travel_request_id' => $this->travelRequest->id,
            'action' => $this->action,
            'user_name' => $this->travelRequest->user->name,
            'purpose' => $this->travelRequest->purpose,
            'destination' => $this->travelRequest->destination,
            'start_date' => $this->travelRequest->start_date->format('M d, Y'),
            'end_date' => $this->travelRequest->end_date->format('M d, Y'),
            'budget' => number_format($this->travelRequest->budget, 0, ',', '.'),
            'status' => $this->travelRequest->status,
        ];

        if ($this->actionBy) {
            $data['action_by'] = $this->actionBy->name;
        }

        switch ($this->action) {
            case 'submitted':
                $data['title'] = 'New Travel Request';
                $data['message'] = $this->travelRequest->user->name . ' submitted a travel request to ' . $this->travelRequest->destination;
                $data['icon'] = 'fas fa-paper-plane';
                $data['color'] = 'primary';
                break;

            case 'approved':
                $data['title'] = 'Request Approved';
                $data['message'] = 'Your travel request to ' . $this->travelRequest->destination . ' has been approved';
                $data['icon'] = 'fas fa-check-circle';
                $data['color'] = 'success';
                break;

            case 'rejected':
                $data['title'] = 'Request Rejected';
                $data['message'] = 'Your travel request to ' . $this->travelRequest->destination . ' has been rejected';
                $data['icon'] = 'fas fa-times-circle';
                $data['color'] = 'danger';
                break;

            default:
                $data['title'] = 'Travel Request Update';
                $data['message'] = 'Your travel request has been updated';
                $data['icon'] = 'fas fa-info-circle';
                $data['color'] = 'info';
        }

        return $data;
    }
}
