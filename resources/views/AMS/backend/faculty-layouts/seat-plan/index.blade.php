@extends('AMS.backend.faculty-layouts.sidebar')

@section('page-title')
    Seat Plan
@endsection

@section('contents')
@livewire('faculty.dashboard', ['schedule' => $schedule, 'teacher_class' => $teacher_class])

@endsection

