<?php

use App\BookingTime;
use App\EmployeeSchedules;
use App\User;
use Illuminate\Database\Seeder;

class EmployeeScheduleSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

}
