<?php

trait SearchTrait
{
    private function searchBetweenValidation($searchBetween)
    {
        $validValues = ["all", "description", "title", "name_as_author"];

        if ($searchBetween != null && in_array($searchBetween, $validValues)) {
            return trim(htmlspecialchars($searchBetween));
        } else {
            return null;
        }
    }
}
