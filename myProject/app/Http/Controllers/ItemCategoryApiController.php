<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ItemCategory;
use Illuminate\Support\Facades\DB;

class ItemCategoryApiController extends Controller
{
    public function index(){
      return response(ItemCategory::all());
    }
}
