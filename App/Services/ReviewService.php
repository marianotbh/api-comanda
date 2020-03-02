<?php

namespace App\Services;

use App\Models\Review;
use App\Core\Exceptions\AppException;

class ReviewService
{
    function list()
    {
        /** @var Review[] */
        $reviews = Review::whereRemoved_at(null)
            ->orderBy("name")
            ->take(10)
            ->fetch();

        return $reviews;
    }

    function read($id)
    {
        /** @var Review */
        $review = Review::findById($id);

        return $review;
    }

    function create($model)
    {
        $review = new Review();

        $review->name = $model->name;
        $review->description = $model->description;

        if (!$review->create()) throw new AppException("Review could not be processed");

        return $review;
    }

    function update($id, $model)
    {
        /** @var Review */
        $review = Review::findById($id);

        if ($review == null) throw new AppException("Review not found");

        $review->name = $model->name;
        $review->description = $model->description;
        $review->updated_at = date('Y-m-d H:i:s');

        return $review->edit();
    }

    function remove($id)
    {
        /** @var Review */
        $review = Review::findById($id);

        if ($review == null) throw new AppException("Review not found");

        $review->removed_at = date('Y-m-d H:i:s');

        return $review->edit();
    }

    function delete($id)
    {
        /** @var Review */
        $review = Review::findById($id);

        if ($review == null) throw new AppException("Review not found");

        return $review->delete();
    }

    function changeState($id)
    {
        /** @var Review */
        $review = Review::find($id);

        if ($review == null) throw new AppException("Review not found");

        if ($review->removed_at == null) {
            $review->removed_at = date('Y-m-d H:i:s');
        } else {
            $review->removed_at = null;
        }

        return $review->edit();
    }
}
