<?php

namespace App\Http\Controllers\Api\Transformers;

use App\Modules\Course\Course;
use League\Fractal\TransformerAbstract;

class CourseTransformer extends TransformerAbstract
{
    /**
     * @param Course $course
     *
     * @return array
     */
    public function transform(Course $course)
    {
        return [
            'id' => $course->getId(),
            'code' => $course->getCode(),
            'name' => $course->getName(),
            'level' => $course->getLevel(),
            'training_package' => $course->getTrainingPackage(),
            'selling_price' => $course->getSellingPrice(),
            'initial_price' => $course->getInitialPrice(),
            'best_market_price' => $course->getBestMarketPrice(),
            'user_comments' => $course->getUserComments(),
            'target_market' => $course->getTargetMarket(),
            'times_completed' => $course->getTimesCompleted(),
            'active' => $course->getActive(),
            'status' => $course->getStatus(),
            'online' => $course->getOnline(),
            'trades' => $course->getTrades(),
            'faculty' => $course->getFaculty(),
            'is_mapped' => $course->getIsMapped(),
            'links' => ['uri' => '/course/' . $course->getId()]
        ];
    }
}
