<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer_Ratings;

class CustomerReviews extends Component
{
    public $reviews;         // كل التقييمات
    public $replyText = [];  // الردود المدخلة من الفورم

    public $rating = 0;
    public $review = '';
    public $visible = true;

    public function mount()
    {
        $this->loadReviews();
    }

    public function loadReviews()
    {
        $this->reviews = Customer_Ratings::where('is_visible', true)
            ->orderByDesc('created_at')
            ->get();
    }

    public function sendReply($reviewId)
    {
        $reply = trim($this->replyText[$reviewId] ?? '');

        if ($reply) {
            $review = Customer_Ratings::find($reviewId);

            if ($review) {
                $data = is_array($review->additional_data)
                    ? $review->additional_data
                    : (is_string($review->additional_data) ? json_decode($review->additional_data, true) : []);

                $data['reply'] = $reply;

                $review->additional_data = $data;
                $review->save();
            }

            $this->replyText[$reviewId] = ''; // امسح حقل الإدخال
            $this->loadReviews();             // حدث القائمة
        }
    }

    public function hideReview($reviewId)
    {
        $review = Customer_Ratings::find($reviewId);
        if ($review) {
            $review->is_visible = false;
            $review->save();
        }

        $this->loadReviews();
    }

    public function render()
    {
        return view('livewire.customer-reviews');
    }
}
