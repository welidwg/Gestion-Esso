@extends('dashboard/base') @section('title')
    @php
        $date = request('date');
        $month = date('m', strtotime($date));
        $monthM = date('M', strtotime($date));
        $year = date('Y', strtotime($date));
    @endphp
    Rapport Mois {{ date('M', strtotime($monthM)) }}
@endsection
@php
    use App\Models\Releve;
    
@endphp
@section('content')
    @php
        
        $dates = Releve::select('date_systeme')
            ->whereMonth('date_systeme', date('m', strtotime($date)))
            ->whereYear('date_systeme', date('Y', strtotime($date)))
            ->distinct()
            ->get();
        // $releves = Releve::whereMonth('date_systeme', date('m', strtotime($date)))
        //     ->whereYear('date_systeme', date('Y', strtotime($date)))
        //     ->get();
    @endphp
    <div class="card shadow">
        <div class="card-body">

            <div class="table-responsive table mt-2 border-0" role="grid" aria-describedby="">
                <table class="table my-0 " id="table_rapport" style="table-layout: fixed;width: 100%">
                    <thead>
                        <tr>
                            <th>Date </th>
                            <th>1ère période</th>
                            <th>2ème période</th>
                            <th>3ème période</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        @foreach ($dates as $date)
                            @php
                                $totalSaisie = 0;
                                $totalPdf = 0;
                                $diff = 0;
                                $exp = '';
                            @endphp
                            <tr>
                                <td class="fw-bold">{{ $date->date_systeme }}</td>
                                @php
                                    $releves = Releve::where('date_systeme', $date->date_systeme)->get();
                                    $count = $releves->count();
                                    
                                    $diff_count = 3 - $count;
                                    
                                @endphp
                                @foreach ($releves as $rel)
                                    <td
                                        @if ($rel->diff != '0') style='background-color:rgba(255,0,0,0.1)' @else style="background-color::rgba(248, 249, 252,1)" @endif>
                                        <span><strong>Total Saisie (€) :</strong> {{ $rel->totalSaisie }} </span>
                                        <br>
                                        <span><strong>Total Rapport (€) :</strong> {{ $rel->totalPdf }} </span>
                                        <br>
                                        <span><strong>Différence (€) :</strong> <span
                                                class="{{ $rel->diff != 0 ? 'text-danger' : '' }}">{{ $rel->diff }}
                                            </span>
                                        </span>
                                        <br>
                                        <p class="w-50 "><strong>Explication : </strong>
                                            <span style="font-size: 14px">
                                                @if ($rel->explication != null)
                                                    <br> {{ $rel->explication }}
                                                @else
                                                    ---
                                                @endif
                                            </span>
                                        </p>
                                    </td>
                                @endforeach
                                @if ($diff_count != 0)
                                    @for ($i = 0; $i < $diff_count; $i++)
                                        <td>---</td>
                                    @endfor
                                @endif




                            </tr>
                        @endforeach


                    </tbody>

                </table>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#table_rapport').DataTable({
                    "order": [],
                    dom: 'Bfrtip',
                    "pageLength": 31,
                    buttons: [
                        {
                            extend: "pdf",
                            className: "btn-primary",
                            title: "test",
                            customize: function(doc) {
                                // Get the table node in the PDF document
                                var table = doc.content[1].table.body;

                                // Iterate over each row in the table
                                table.forEach(function(row, rowIndex) {
                                    // Iterate over each cell in the row
                                    row.forEach(function(cell, cellIndex) {
                                        // Get the background color of the corresponding cell in the HTML table
                                        var bgColor = $('#table_rapport tr:eq(' +
                                            rowIndex +
                                            ') td:eq(' + cellIndex + ')').css(
                                            'background-color');

                                        // Apply the background color to the PDF cell
                                        if (bgColor == "rgba(255, 0, 0, 0.1)") {
                                            cell.fillColor = "#ffc6c4";
                                            cell.textColor = "white";
                                        }

                                    });
                                });
                            }
                        }
                    ]
                });
            });
        </script>
    </div>
@endsection
