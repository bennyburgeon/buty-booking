<?php

use App\CustomerFeedback;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerFeedbackTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedInteger('booking_id')->nullable();
            $table->foreign('booking_id')->references('id')->on('bookings')->onUpdate('cascade')->onDelete('cascade');
            $table->string('customer_name');
            $table->text('feedback_message');
            $table->enum('status', ['active', 'inactive'])->default('inactive');
            $table->timestamps();
        });

        $custFeedbacks = [
            'feedback_first' => [
                'customer_name' => 'Henry Dube',
                'feedback_message' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti
                quos. At vero eos et accusamus et iusto odio.',
            ],
            'feedback_two' => [
                'customer_name' => 'John Doe',
                'feedback_message' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti
                quos. At vero eos et accusamus et iusto odio.',
            ],
            'feedback_three' => [
                'customer_name' => 'Celena Gomez',
                'feedback_message' => 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti
                atque corrupti
                quos. At vero eos et accusamus et iusto odio.',
            ],
        ];

        foreach ($custFeedbacks as $custFeedback) {

            $feedback = new CustomerFeedback();
            $feedback->customer_name = $custFeedback['customer_name'];
            $feedback->feedback_message = $custFeedback['feedback_message'];
            $feedback->status = 'active';
            $feedback->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_feedback');
    }

}
