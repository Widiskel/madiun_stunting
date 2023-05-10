@extends('layouts.app')

@section('title')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a>
        </li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page"><a href="{{route('puskesmas.index')}}">Puskesmas</a> </li>
    </ol>
    <h6 class="font-weight-bolder mb-0">{{$puskesmas['puskesmas_name']}} ({{$puskesmas['year']}})</h6>
</nav>
@endsection

@section('main')
    <div class="container-fluid py-4">
        <div class="row my-4">
            <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>{{$puskesmas['puskesmas_name']}}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Bulan
                                    </th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Stunting
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $data = array_slice($puskesmas,2,12);
                                @endphp
                            @foreach ($data as $key=>$item)
                                <tr>
                                    <td class="align-middle text-center text-sm">{{$key}}</td>
                                    <td class="align-middle text-center text-sm">{{$item}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="align-middle text-center text-sm">
                                    Total
                                </td>
                                <td class="align-middle text-center text-sm">
                                    {{$puskesmas['total']}}
                                </td>

                            </tr>
                            </tbody>
                        </table>
                        
                    </div>
                    
                </div>
            </div>
        </div>   
    </div>
@endsection
