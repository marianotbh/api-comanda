<?php

namespace App\Services;

use App\Core\Data\QueryBuilder;
use App\Models\Review;
use App\Core\Exceptions\AppException;

use function App\Core\Utils\kebabize;

class ReviewService
{
    function list($page = 1, $length = 100, $field = "createdAt", $order = "ASC")
    {
        /** @var Review[] */
        $reviews = Review::whereRemoved_at(null)
            ->orderBy(kebabize($field), $order)
            ->skip(($page - 1) * $length)
            ->take($length)
            ->fetch();

        return $reviews;
    }

    function averages()
    {
        return [
            "menu" => Review::avg("menu_score"),
            "table" => Review::avg("table_score"),
            "service" => Review::avg("service_score"),
            "environment" => Review::avg("environment_score"),
        ];
    }

    function read($id)
    {
        /** @var Review */
        $review = Review::find($id);

        if ($review == null || $review->removed_at != null) {
            return null;
        }

        return $review;
    }

    function create($model)
    {
        $review = new Review();

        $review->name = $model->name;
        $review->description = $model->description;
        $review->email = $model->email;
        $review->menu_score = $model->menuScore;
        $review->table_score = $model->tableScore;
        $review->service_score = $model->serviceScore;
        $review->environment_score = $model->environmentScore;

        if (!$review->create()) throw new AppException("Review could not be processed");

        return $review;
    }

    function update($id, $model)
    {
        /** @var Review */
        $review = Review::find($id);

        if ($review == null || $review->removed_at != null) throw new AppException("Review not found");

        $review->name = $model->name;
        $review->description = $model->description;
        $review->email = $model->email;
        $review->menu_score = $model->menuScore;
        $review->table_score = $model->tableScore;
        $review->service_score = $model->serviceScore;
        $review->environment_score = $model->environmentScore;
        $review->updated_at = date('Y-m-d H:i:s');

        return $review->edit();
    }

    function delete($id)
    {
        /** @var Review */
        $review = Review::find($id);

        if ($review == null || $review->removed_at != null) throw new AppException("Review not found");

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
