<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('clean:old-students')]
#[Description('1 yildan oshgan o\'chirilgan o\'quvchilarni butunlay o\'chirish')]
class CleanSoftDeletedStudents extends Command
{
    public function handle()
    {
        $count = Student::onlyTrashed()
            ->where('deleted_at', '<', now()->subYear())
            ->forceDelete();

        $this->info("$count ta o'quvchi butunlay o'chirildi.");
    }
}
