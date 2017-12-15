@extends('layouts.admin_main')

@section('status')
    PHP Version: {{isset($phpVer) ? $phpVer : "Can't access variable"}}<br>
    MySQL Version: {{isset($mysqlVersion) ? $mysqlVersion : "Can't access variable"}}
@endsection
