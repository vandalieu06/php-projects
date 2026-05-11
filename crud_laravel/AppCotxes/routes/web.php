<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CotxeController;

Route::get("/", function () {
    return view("welcome");
});

Route::get("/cotxes", [CotxeController::class, "index"])->name("cotxes.index");
Route::get("/cotxes/create", [CotxeController::class, "create"])->name(
    "cotxes.create",
);
Route::post("/cotxes", [CotxeController::class, "store"])->name("cotxes.store");
Route::get("/cotxes/{cotxe}", [CotxeController::class, "show"])->name(
    "cotxes.show",
);
Route::get("/cotxes/{cotxe}/edit", [CotxeController::class, "edit"])->name(
    "cotxes.edit",
);
Route::put("/cotxes/{cotxe}", [CotxeController::class, "update"])->name(
    "cotxes.update",
);
Route::delete("/cotxes/{cotxe}", [CotxeController::class, "destroy"])->name(
    "cotxes.destroy",
);
