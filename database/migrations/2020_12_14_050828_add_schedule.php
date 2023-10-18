<?php

use App\User;
use App\BookingTime;
use App\EmployeeSchedules;
use Illuminate\Database\Migrations\Migration;

class AddSchedule extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $bookingTime = BookingTime::all();

        $employee = User::AllEmployees()->get();

        foreach($employee as $employees){

            foreach($bookingTime as $bookingTimes){

                $employeeSchedule = new EmployeeSchedules();
                $employeeSchedule->employee_id = $employees->id;
                $employeeSchedule->start_time = $bookingTimes->start_time;
                $employeeSchedule->end_time = $bookingTimes->end_time;
                $employeeSchedule->days = $bookingTimes->day;

                if($bookingTimes->status == 'enabled'){
                    $employeeSchedule->is_working = 'yes';
                }
                else {
                    $employeeSchedule->is_working = 'no';
                }
                
                $employeeSchedule->save();

            }

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

}
