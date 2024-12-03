@extends('layouts.base')
@section('content')

<div class="min-h-screen min-h-screen max-w-full mx-auto p-4 sm:p-6 space-y-8">

  <?php $report->render(); ?>

</div>
@endsection