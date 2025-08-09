<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Course;
use Tests\TestCase;

class CourseTest extends TestCase
{
    private Course $courseModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->courseModel = new Course();
    }

    public function test_can_create_a_course()
    {
        $courseData = [
            'title' => 'My Test Course ' . uniqid(),
            'description' => 'A description for the test course.'
        ];

        $courseId = $this->courseModel->create($courseData);
        $this->assertNotFalse($courseId);

        $newCourse = $this->courseModel->findById($courseId);
        $this->assertEquals($courseData['title'], $newCourse['title']);
    }

    public function test_can_update_a_course()
    {
        $courseData = [
            'title' => 'Updatable Course ' . uniqid(),
            'description' => 'Initial description.'
        ];
        $courseId = $this->courseModel->create($courseData);

        $updatedData = [
            'title' => 'My Updated Course Title',
            'description' => 'Updated description.'
        ];
        $success = $this->courseModel->update($courseId, $updatedData);
        $this->assertTrue($success);

        $updatedCourse = $this->courseModel->findById($courseId);
        $this->assertEquals($updatedData['title'], $updatedCourse['title']);
    }

    public function test_can_delete_a_course()
    {
        $courseData = [
            'title' => 'Deletable Course ' . uniqid(),
            'description' => 'This will be deleted.'
        ];
        $courseId = $this->courseModel->create($courseData);

        $this->assertIsArray($this->courseModel->findById($courseId));

        $success = $this->courseModel->delete($courseId);
        $this->assertTrue($success);

        $this->assertFalse($this->courseModel->findById($courseId));
    }

    public function test_can_find_all_courses()
    {
        // This test relies on the seed data having at least two courses
        $courses = $this->courseModel->findAll();
        $this->assertIsArray($courses);
        $this->assertGreaterThanOrEqual(2, count($courses));
    }

    public function test_can_find_course_by_slug()
    {
        // This test relies on the seed data
        $course = $this->courseModel->findBySlug('web-development-basics');
        $this->assertIsArray($course);
        $this->assertEquals('Web Development Basics', $course['title']);
        $this->assertArrayHasKey('modules', $course);
        $this->assertCount(2, $course['modules']);
    }
}
