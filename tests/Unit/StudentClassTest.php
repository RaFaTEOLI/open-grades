<?php

namespace Tests\Unit;

use App\Exceptions\AlreadyEnrolled;
use App\Exceptions\NoStudentToEnroll;
use App\Exceptions\NotResponsible;
use App\Exceptions\StudentCannotEnroll;
use App\Models\Classes;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Role;
use App\Models\StudentsClasses;
use App\Repositories\Configuration\ConfigurationRepository;
use App\Services\StudentClass\CreateStudentClassService;
use App\Services\StudentClass\FetchStudentClassService;
use App\Services\StudentClass\RemoveStudentClassService;
use App\Services\StudentClass\UpdateStudentClassService;
use App\Services\StudentsResponsible\AddStudentsResponsibleService;
use Exception;

class StudentClassTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * It should enroll student to a class
     *
     * @return void
     */
    public function testShouldEnrollStudentToAClass()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $class = factory(Classes::class)->create();

        $request = [
            "student_id" => $student->id,
            "class_id" => $class->id,
        ];

        $createStudentClassService = new CreateStudentClassService();
        $studentClass = $createStudentClassService->execute($request);

        $this->assertTrue(is_numeric($studentClass->id));
    }

    /**
     * It should not enroll student to a class because the user is not his responsible
     *
     * @return void
     */
    public function testShouldNotEnrollStudentToAClassBecauseTheUserIsNotHisResponsible()
    {
        $this->expectException(NotResponsible::class);
        $user = factory(User::class)->create();

        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $student = factory(User::class)->create();

        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $class = factory(Classes::class)->create();

        $request = [
            "student_id" => $student->id,
            "class_id" => $class->id,
        ];

        $createStudentClassService = new CreateStudentClassService();
        $createStudentClassService->execute($request);
    }

    /**
     * It should fetch student class as admin
     *
     * @return void
     */
    public function testShouldFetchAStudentClassAsAdmin()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        $fetchStudentClassService = new FetchStudentClassService();
        $fetched = $fetchStudentClassService->execute($studentClass->id);

        $this->assertTrue(is_numeric($fetched->id));
    }

    /**
     * It should fetch student class as the responsible
     *
     * @return void
     */
    public function testShouldFetchAStudentClassAsResponsible()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        (new AddStudentsResponsibleService())->execute(['student_id' => $studentClass->user_id, 'responsible_id' => $user->id]);

        $fetchStudentClassService = new FetchStudentClassService();
        $fetched = $fetchStudentClassService->execute($studentClass->id);

        $this->assertTrue(is_numeric($fetched->id));
    }

    /**
     * It should fetch student class as the student
     *
     * @return void
     */
    public function testShouldFetchAStudentClassAsStudent()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "student")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $class = factory(Classes::class)->create();

        $request = [
            "student_id" => $user->id,
            "class_id" => $class->id,
        ];

        $createStudentClassService = new CreateStudentClassService();
        $studentClass = $createStudentClassService->execute($request);

        $fetchStudentClassService = new FetchStudentClassService();
        $fetched = $fetchStudentClassService->execute($studentClass->id);

        $this->assertTrue(is_numeric($fetched->id));
    }

    /**
     * It should update student class as admin
     *
     * @return void
     */
    public function testShouldUpdateAStudentClassAsAdmin()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        $updateStudentClassService = new UpdateStudentClassService();
        $updated = $updateStudentClassService->execute([
            "id" => $studentClass->id, "presence" => 8,
            "absent" => 10,
            "left_date" => "2021-06-12 10:00:00"
        ]);

        $this->assertTrue($updated);
    }

    /**
     * It should update student class as the responsible
     *
     * @return void
     */
    public function testShouldUpdateAStudentClassAsResponsible()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        (new AddStudentsResponsibleService())->execute(['student_id' => $studentClass->user_id, 'responsible_id' => $user->id]);

        $updateStudentClassService = new UpdateStudentClassService();
        $updated = $updateStudentClassService->execute([
            "id" => $studentClass->id, "presence" => 8,
            "absent" => 10,
            "left_date" => "2021-06-12 10:00:00"
        ]);

        $this->assertTrue($updated);
    }

    /**
     * It should update student class as the student
     *
     * @return void
     */
    public function testShouldUpdateAStudentClassAsStudent()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "student")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $class = factory(Classes::class)->create();

        $request = [
            "student_id" => $user->id,
            "class_id" => $class->id,
        ];

        $createStudentClassService = new CreateStudentClassService();
        $studentClass = $createStudentClassService->execute($request);

        $updateStudentClassService = new UpdateStudentClassService();
        $updated = $updateStudentClassService->execute([
            "id" => $studentClass->id, "presence" => 8,
            "absent" => 10,
            "left_date" => "2021-06-12 10:00:00"
        ]);

        $this->assertTrue($updated);
    }

    /**
     * It should remove student class as admin
     *
     * @return void
     */
    public function testShouldRemoveAStudentClassAsAdmin()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        $removeStudentClassService = new RemoveStudentClassService();
        $removed = $removeStudentClassService->execute($studentClass->id);

        $this->assertTrue($removed);
    }

    /**
     * It should remove student class as the responsible
     *
     * @return void
     */
    public function testShouldRemoveAStudentClassAsResponsible()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        (new AddStudentsResponsibleService())->execute(['student_id' => $studentClass->user_id, 'responsible_id' => $user->id]);

        $removeStudentClassService = new RemoveStudentClassService();
        $removed = $removeStudentClassService->execute($studentClass->id);

        $this->assertTrue($removed);
    }

    /**
     * It should remove student class as the student
     *
     * @return void
     */
    public function testShouldRemoveAStudentClassAsStudent()
    {
        $user = factory(User::class)->create();

        $role = Role::where("name", "student")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $class = factory(Classes::class)->create();

        $request = [
            "student_id" => $user->id,
            "class_id" => $class->id,
        ];

        $createStudentClassService = new CreateStudentClassService();
        $studentClass = $createStudentClassService->execute($request);

        $removeStudentClassService = new RemoveStudentClassService();
        $removed = $removeStudentClassService->execute($studentClass->id);

        $this->assertTrue($removed);
    }

    /**
     * It should not fetch student class because the user is not the responsible
     *
     * @return void
     */
    public function testShouldNotFetchAStudentClassBecauseTheUserIsNotTheResponsible()
    {
        $this->expectException(NotResponsible::class);
        $user = factory(User::class)->create();

        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        $fetchStudentClassService = new FetchStudentClassService();
        $fetchStudentClassService->execute($studentClass->id);
    }

    /**
     * It should not fetch student class because the user is not the student
     *
     * @return void
     */
    public function testShouldNotFetchAStudentClassBecauseTheUserIsNotTheStudent()
    {
        $this->expectException(NotResponsible::class);
        $user = factory(User::class)->create();

        $role = Role::where("name", "student")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        $fetchStudentClassService = new FetchStudentClassService();
        $fetchStudentClassService->execute($studentClass->id);
    }

    /**
     * It should not remove student class because the user is not the responsible
     *
     * @return void
     */
    public function testShouldNotRemoveAStudentClassBecauseTheUserIsNotTheResponsible()
    {
        $this->expectException(NotResponsible::class);
        $user = factory(User::class)->create();

        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        $removeStudentClassService = new RemoveStudentClassService();
        $removeStudentClassService->execute($studentClass->id);
    }

    /**
     * It should not remove student class because the user is not the student
     *
     * @return void
     */
    public function testShouldNotRemoveAStudentClassBecauseTheUserIsNotTheStudent()
    {
        $this->expectException(NotResponsible::class);
        $user = factory(User::class)->create();

        $role = Role::where("name", "student")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        $removeStudentClassService = new RemoveStudentClassService();
        $removeStudentClassService->execute($studentClass->id);
    }

    /**
     * It should not update student class as the responsible
     *
     * @return void
     */
    public function testShouldNotUpdateAStudentClassAsResponsible()
    {
        $this->expectException(NotResponsible::class);
        $user = factory(User::class)->create();

        $role = Role::where("name", "responsible")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        $updateStudentClassService = new UpdateStudentClassService();
        $updateStudentClassService->execute([
            "id" => $studentClass->id, "presence" => 8,
            "absent" => 10,
            "left_date" => "2021-06-12 10:00:00"
        ]);
    }

    /**
     * It should not update student class because the user is not the student
     *
     * @return void
     */
    public function testShouldNotUpdateAStudentClassBecauseTheUserIsNotTheStudent()
    {
        $this->expectException(NotResponsible::class);
        $user = factory(User::class)->create();

        $role = Role::where("name", "student")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        $updateStudentClassService = new UpdateStudentClassService();
        $updateStudentClassService->execute([
            "id" => $studentClass->id, "presence" => 8,
            "absent" => 10,
            "left_date" => "2021-06-12 10:00:00"
        ]);
    }

    /**
     * It should not enroll student when canStudentEnroll flag is false
     * 
     * @return void
     */
    public function testShouldNotEnrollStudentWhenCanStudentEnrollFlagIsFalse()
    {
        $this->expectException(StudentCannotEnroll::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "student")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $configurationRepository = (new ConfigurationRepository());
        $canStudentEnroll = $configurationRepository->findByName('can-student-enroll');
        $configurationRepository->update($canStudentEnroll->id, ["value" => 0]);

        $studentClass = factory(StudentsClasses::class)->create();

        $createStudentClassService = new CreateStudentClassService();
        $createStudentClassService->execute([
            "class_id" => $studentClass->id,
        ]);
    }

    /**
     * It should not enroll student in class because there is no student to enroll
     * 
     * @return void
     */
    public function testShouldNotEnrollStudentInClassBecauseThereIsNoStudentToEnroll()
    {
        $this->expectException(NoStudentToEnroll::class);
        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);

        $this->actingAs($user);

        $studentClass = factory(StudentsClasses::class)->create();

        $createStudentClassService = new CreateStudentClassService();
        $createStudentClassService->execute([
            "class_id" => $studentClass->id,
        ]);
    }

    /**
     * It should not enroll student in class because he is already enrolled
     * 
     * @return void
     */
    public function testShouldNotEnrollStudentInClassBecauseHeIsAlreadyEnrolled()
    {
        $this->expectException(AlreadyEnrolled::class);

        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        $student = factory(User::class)->create();
        $studentRole = Role::where("name", "student")->first();
        $student->attachRole($studentRole);

        $class = factory(Classes::class)->create();

        $request = [
            "student_id" => $student->id,
            "class_id" => $class->id,
        ];
        $createStudentClassService = new CreateStudentClassService();
        $createStudentClassService->execute($request);

        $createStudentClassService->execute($request);
    }

    /**
     * It should throw base Exception if object is not found when trying to fetch student class
     * 
     * @return void
     */
    public function testShouldThrowBaseExceptionIfObjectIsNotFoundWhenTryingToFetchStudentClass()
    {
        $this->expectException(Exception::class);

        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        (new FetchStudentClassService())->execute(0);
    }

    /**
     * It should throw base Exception if object is not found when trying to remove student class
     * 
     * @return void
     */
    public function testShouldThrowBaseExceptionIfObjectIsNotFoundWhenTryingToRemoveStudentClass()
    {
        $this->expectException(Exception::class);

        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        (new RemoveStudentClassService())->execute(0);
    }

    /**
     * It should throw base Exception if request is empty when updating the student class
     * 
     * @return void
     */
    public function testShouldThrowBaseExceptionIfRequestIsEmptyWhenUpdatingTheStudentClass()
    {
        $this->expectException(Exception::class);

        $user = factory(User::class)->create();
        $role = Role::where("name", "admin")->first();
        $user->attachRole($role);
        $this->actingAs($user);

        (new UpdateStudentClassService())->execute([0]);
    }
}
