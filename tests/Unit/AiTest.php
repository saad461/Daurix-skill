<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Ai;
use Tests\TestCase;

class AiTest extends TestCase
{
    private Ai $aiModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->aiModel = new Ai();
    }

    public function test_can_find_relevant_course_summaries_for_rag()
    {
        // This test relies on the seed data.
        // The seed data for course_id=1 is about "Web Development Basics".
        $message = "I want to learn about web development and javascript";

        $summaries = $this->aiModel->findRelevantSummaries($message);

        $this->assertIsArray($summaries);
        $this->assertNotEmpty($summaries);

        // Check if the returned summary contains expected keywords.
        $this->assertStringContainsStringIgnoringCase('web development basics', $summaries[0]);
    }

    public function test_returns_empty_array_for_irrelevant_message()
    {
        $message = "what is the best way to cook a pizza";
        $summaries = $this->aiModel->findRelevantSummaries($message);
        $this->assertIsArray($summaries);
        $this->assertEmpty($summaries);
    }
}
