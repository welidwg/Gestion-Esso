<?php

namespace App\Http\Controllers;

use App\Models\Desiderata;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesiderataController extends Controller
{
    public function index()
    {


        $users = Auth::user()->role == 0
            ? User::where('role', '!=', 0)
            ->orderBy('nom')
            ->get(['id', 'nom', 'login'])
            : collect();

        $existingChoices = Desiderata::where('user_id', Auth::id())->get();
        return view('dashboard.pages.desiderata.index', compact('existingChoices', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'choosen_date' => 'required|date',
            'shift_start' => 'required|date_format:H:i',
            'shift_end' => 'required|date_format:H:i|after:shift_start',
            'user_id' => 'required|exists:users,id'
        ]);

        // For non-admin users, verify they can only modify their own shifts
        if (auth()->user()->role != 0 && $validated['user_id'] != auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Convert times to minutes for comparison
        $newStart = $this->timeToMinutes($validated['shift_start']);
        $newEnd = $this->timeToMinutes($validated['shift_end']);

        // Check for overlapping shifts excluding current shift if updating
        $overlapping = Desiderata::where('choosen_date', $validated['choosen_date'])
            ->where('id', '!=', $request->input('shift_id', 0)) // Exclude current shift if updating
            ->get()
            ->contains(function ($item) use ($newStart, $newEnd) {
                $itemStart = $this->timeToMinutes($item->shift_start);
                $itemEnd = $this->timeToMinutes($item->shift_end);
                return ($newStart < $itemEnd && $newEnd > $itemStart);
            });

        if ($overlapping) {
            return response()->json([
                'message' => 'Ce créneau horaire est déjà pris'
            ], 422);
        }

        // Update or create the shift
        Desiderata::updateOrCreate(
            [
                'id' => $request->input('shift_id'), // For updates
                'choosen_date' => $validated['choosen_date'],
                'user_id' => $validated['user_id']
            ],
            [
                'shift_start' => $validated['shift_start'],
                'shift_end' => $validated['shift_end']
            ]
        );

        return response(["success" => "Bien ajouté"], 201);
    }

    private function timeToMinutes($timeStr)
    {
        list($hours, $minutes) = explode(':', $timeStr);
        return $hours * 60 + $minutes;
    }

    public function events()
    {
        $desideratas = Desiderata::where('user_id', Auth::id())->with("caissier")->get();
        if (Auth::user()->role == 0) {
            $desideratas = Desiderata::with("caissier")->get();
        }

        return $desideratas->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->shift_start . ' - ' . $item->shift_end .
                    ' (' . $item->caissier->login . ')',
                'start' => $item->choosen_date,
                'allDay' => true,
                'shift_start' => $item->shift_start,
                'shift_end' => $item->shift_end,
                'userId' => $item->user_id,
                'userName' => $item->caissier->login ?? 'Unknown'
            ];
        });

        return response()->json($events);
    }


    public function getShiftsForDate(Request $request)
    {
        $date = $request->query('date');
        $excludeUserId = $request->query('exclude_user');

        $query = Desiderata::where('choosen_date', $date)
            ->with('caissier')
            ->select('id', 'shift_start', 'shift_end', 'user_id');

        if ($excludeUserId) {
            $query->where('user_id', '!=', $excludeUserId);
        }

        return $query->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'shift_start' => $item->shift_start,
                    'shift_end' => $item->shift_end,
                    'user_id' => $item->user_id,
                    'user_name' => $item->caissier->login ?? 'Unknown'
                ];
            });
    }

    public function generateReport(Request $request)
    {
        $year = $request->query('year');
        $month = $request->query('month');

        // Get all non-admin users
        $users = User::where('role', '!=', 0)
            ->orderBy('nom')
            ->get(['id', 'nom', 'login']);

        // Get all days in the month
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
        $dates = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::createFromDate($year, $month, $day)->format('Y-m-d');

            // Get shifts for this date
            $shifts = Desiderata::whereDate('choosen_date', $date)
                ->with('caissier')
                ->get()
                ->map(function ($item) {
                    return [
                        'user_id' => $item->user_id,
                        'shift_start' => $item->shift_start,
                        'shift_end' => $item->shift_end,
                        'user_name' => $item->caissier->nom ?? 'Unknown'
                    ];
                });

            $dates[] = [
                'date' => Carbon::createFromDate($year, $month, $day)->format('d/m/Y'),
                'shifts' => $shifts
            ];
        }

        return response()->json([
            'users' => $users,
            'dates' => $dates
        ]);
    }

    public function destroy($id)
    {
        $desiderata = Desiderata::where('id', $id)->firstOrFail();
        $desiderata->delete();

        return response()->json(['message' => 'Shift deleted']);
    }
}
