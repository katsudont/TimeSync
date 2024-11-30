<?php

namespace App\Controllers;

use App\Models\Shift;

class ShiftController extends BaseController
{
    // Display the list of shifts
    public function index()
    {
        $shiftModel = new Shift();

        // Get all shifts
        $shifts = $shiftModel->getAllShifts();

        // Render the shifts table
        $this->render('shift', ['shifts' => $shifts]);
    }

    // Edit a shift
    public function edit($shiftId)
    {
        $shiftModel = new Shift();

        // Get the shift by ID
        $shift = $shiftModel->getById($shiftId);
        if (!$shift) {
            echo "Shift not found.";
            return;
        }

        // Check if it's a POST request to update the shift
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $timeIn = $_POST['timeIn'];  // Get the new TimeIn
            $timeOut = $_POST['timeOut']; // Get the new TimeOut

            // Update the shift
            $shiftModel->updateShift($shiftId, $timeIn, $timeOut);

            // Redirect back to the shift list
            header('Location: /shift');
            exit();
        }

        // Render the edit form
        $this->render('editShift', ['shift' => $shift]);
    }

    // Add a new shift
    public function add()
{
    $shiftModel = new Shift();

    // Check if it's a POST request to add the new shift
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $timeIn = $_POST['timeIn'];  // Corrected: matches form input name
        $timeOut = $_POST['timeOut']; // Corrected: matches form input name

        // Insert the new shift by passing an associative array
        $shiftModel->create([
            'TimeIn' => $timeIn,
            'TimeOut' => $timeOut
        ]);

        // Redirect back to the shift list
        header('Location: /shift');
        exit();
    }

    // Render the add shift form
    $this->render('addShift');
}

}
