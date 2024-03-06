<?php

namespace App\Services;

use App\Models\Concept;

class ConceptService
{
    public function getConcepts()
    {
        return Concept::query()
            ->with('lastExpenditure')
            ->orderBy('name')
            ->paginate();
    }

    public function getTypeRecords($concept, $type)
    {
        return $type == 'incomes'
            ? $concept->incomes()->latest()->paginate(20)
            : $concept->expenditures()->latest()->paginate(20);
    }
}
