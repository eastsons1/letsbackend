<?php
error_reporting(0);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

require_once("config.php");

header('content-type:application/json');

// Function to calculate distance
function distance($lat1, $lon1, $lat2, $lon2, $unit) 
{
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $unit = strtoupper($unit);

    if ($unit == "K") {
        return ($miles * 1.609344);
    } else if ($unit == "N") {
        return ($miles * 0.8684);
    } else {
        return $miles;
    }
}

// Read input data
$data = file_get_contents("php://input");
$array = json_decode($data, true);

// Initialize variables
$student_lat = $array['student_lat'];
$student_long = $array['student_long'];    
$logged_in_student_id = $array['logged_in_student_id'];

/**
$subjectMappings = [
];

**/

// Map for specific subjects (like "Science") to related terms
$subjectMappings = [
    'Science' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Computer' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Physics' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Chemistry' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Physics H1' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Physics H2' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Physics H3' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Physics Engineering' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Physics SL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Physics HL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Pure Physics' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Science Chemistry' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Pure Chemistry' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Chemistry H1' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Chemistry H2' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Chemistry H3' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Chemistry Engineering' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Chemistry SL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Chemistry HL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Biology' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Biology H1' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Biology H2' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Biology H3' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Biology SL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Biology HL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Science Biology' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Pure Biology' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Mechanics' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Science Foundation' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Java' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'JavaScript' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Python' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
     'C' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
     'C++' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
     'C#' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
     'HTML' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
     'CSS' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'SQL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'PERL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'PHP' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'App Development' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Website Development' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Computer Science SL' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Computer Engineering' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Computer Science H1' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Computer Science H2' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    'Electronics' => ['Computer', 'Science', 'Physics', 'Physics H1', 'Physics H2', 'Physics H3', 'Physics Engineering', 'Physics SL', 'Physics HL', 'Pure Physics', 'Science Chemistry', 'Pure Chemistry', 'Chemistry', 'Chemistry H1', 'Chemistry H2', 'Chemistry H3', 'Chemistry Engineering', 'Chemistry SL', 'Chemistry HL', 'Biology', 'Biology H1', 'Biology H2', 'Biology H3', 'Biology SL', 'Biology HL', 'Science Biology', 'Pure Biology', 'Mechanics', 'Science Foundation', 'Java', 'JavaScript', 'Python', 'C', 'C++', 'C#', 'HTML', 'CSS', 'SQL', 'PERL', 'PHP', 'App Development', 'Website Development', 'Computer Science SL', 'Computer Engineering', 'Computer Science H1', 'Computer Science H2', 'Electronics'],
    
    'English' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
    'IELTS' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
	'Theory of Knowledge TOK' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
    'TOEFL' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
    'Project Work PW' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
    'General Paper GP' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
    'Literature' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
    
    'Math' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
    'Mathematics' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
    'Mathematics H1' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
    'Mathematics H2' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
    'Mathematics HL' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
    'Mathematics SL' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
    'Statistics' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
    'Mathematics H3' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
    'Further Mathematics' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
    'Additional Math' => ['Math', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
    
    'Chinese' => ['Chinese', 'Chinese H1', 'Chinese H2', 'Mandarin', 'Higher Chinese'],
	'Chinese H1' => ['Chinese', 'Chinese H1', 'Chinese H2', 'Mandarin', 'Higher Chinese'],
	'Chinese H2' => ['Chinese', 'Chinese H1', 'Chinese H2', 'Mandarin', 'Higher Chinese'],
	'Mandarin' => ['Chinese', 'Chinese H1', 'Chinese H2', 'Mandarin', 'Higher Chinese'],
	'Higher Chinese' => ['Chinese', 'Chinese H1', 'Chinese H2', 'Mandarin', 'Higher Chinese'],
    
    'Economics' => ['Economics', 'Economics H1', 'Economics H2', 'Mandarin'],
	'Economics H1' => ['Economics', 'Economics H1', 'Economics H2', 'Mandarin'],
	'Economics H2' => ['Economics', 'Economics H1', 'Economics H2', 'Mandarin'],
	'Mandarin' => ['Economics', 'Economics H1', 'Economics H2', 'Mandarin']
];




// Start building the SQL conditions array
$conditions = [];

// Initialize the HAVING clause
$havingConditions = [];

// Handle distance filter
if (!empty($array['student_lat']) && !empty($array['student_long'])) {
    $sql_Q = $conn->query("SELECT tuition_type, user_id, lettitude, longitude, travel_distance FROM user_tutor_info");
    $tutor_ids = [];
    while ($get_Data = mysqli_fetch_assoc($sql_Q)) {
        if (!empty($get_Data['lettitude']) && !empty($get_Data['longitude'])) {
            $distance_value = distance($student_lat, $student_long, $get_Data['lettitude'], $get_Data['longitude'], "K");
            if ((int)$distance_value <= (int)$get_Data['travel_distance']) {
                $tutor_ids[] = $get_Data['user_id'];
            }
        }
    }
    if (!empty($tutor_ids)) {
        $conditions[] = "user_tutor_info.user_id IN ('" . implode("','", $tutor_ids) . "')";
    }


// Handle gender filter
if (!empty($array['gender'])) {
    $gender_values = implode("','", $array['gender']);
    $conditions[] = "user_tutor_info.gender IN ('{$gender_values}')";
}

// Handle nationality filter
if (!empty($array['nationality'])) {
    $nationality_values = implode("','", $array['nationality']);
    $conditions[] = "user_tutor_info.nationality IN ('{$nationality_values}')";
}

// Handle subjects filter
// Handle subjects filter
// Handle subjects filter
// Filter tutors based on subjects
if (!empty($array['subjects'])) {
    $subjectConditions = [];

    // Loop through the requested subjects
    foreach ($array['subjects'] as $subject) {
        if (array_key_exists($subject, $subjectMappings)) {
            $mappedConditions = [];
            foreach ($subjectMappings[$subject] as $mappedSubject) {
                // Create a condition for each mapped subject
                $mappedConditions[] = "complete_user_profile_tutoring_tutoring_subjects_detail.Tutoring_ALL_Subjects = '{$mappedSubject}'";
            }

            // Combine conditions for the requested subject
            if (!empty($mappedConditions)) {
                // Join mapped subjects with OR and add to overall condition list
                $subjectConditions[] = "(" . implode(" OR ", $mappedConditions) . ")";
            }
        } else {
            // If no mapping, use the subject itself
            $subjectConditions[] = "complete_user_profile_tutoring_tutoring_subjects_detail.Tutoring_ALL_Subjects = '{$subject}'";
        }
    }

    // Combine subject conditions with AND (all conditions must be met)
    if (!empty($subjectConditions)) {
        $conditions[] = "(" . implode(" AND ", $subjectConditions) . ")";
    }
}



// Handle qualification filter
if (!empty($array['qualification'])) {
    $qualification_values = implode("','", $array['qualification']);
    $conditions[] = "user_tutor_info.qualification IN ('{$qualification_values}')";
}



// Handle tutoring level filter
if (!empty($array['TutoringLevel'])) {
    $tutoring_level_values = implode("','", $array['TutoringLevel']);
	
	//if($array['TutoringLevel']=="AEIS")
	//{
	//	$conditions[] = "complete_user_profile_tutoring_admission_level.TutoringLevel IN ('{$tutoring_level_values}')";
	//}
	//else{
	
		$conditions[] = "complete_user_profile_tutoring_detail.TutoringLevel IN ('{$tutoring_level_values}')";
    //}
	
    // Count distinct tutoring levels
   // $havingConditions[] = "COUNT(DISTINCT complete_user_profile_tutoring_detail.TutoringLevel) = " . count($array['TutoringLevel']);
}


$AdmissionLevel_val = $array['AdmissionLevel'];


// Handle admission level filter
if (!empty($array['AdmissionLevel'])) {
    $admission_level_values = implode("','", $array['AdmissionLevel']);
	
	if($AdmissionLevel_val[0] == "Primary" || $AdmissionLevel_val[0] == "Secondary")
	{
		$conditions[] = "complete_user_profile_tutoring_detail.AdmissionLevel IN ('{$admission_level_values}')";
	}
	else{
	
		$conditions[] = "complete_user_profile_tutoring_admission_level.AdmissionLevel IN ('{$admission_level_values}')";

	}
}

// Handle grade filter
if (!empty($array['grade'])) {
    $grade_values = implode("','", $array['grade']);
    $conditions[] = "complete_user_profile_tutoring_grade_detail.Tutoring_Grade IN ('{$grade_values}')";
}


//For Multiple Stream 
			
if(!empty($array['stream']))
{
	$streamString = implode("','", $array['stream']);
	
	$conditions[] =  "complete_user_profile_tutoring_admission_stream.Stream IN ('{$streamString}')";
}


if(!empty($array['tutor_status']))
{
	$tutor_status_arr = implode("','", $array['tutor_status']);

	$conditions[] =  "user_tutor_info.tutor_status IN ('{$tutor_status_arr}')";
}
				



// Dynamically build WHERE clause from conditions array
$whereClause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";



// Handle sorting
$sorting = "";
if (!empty($array['sorting'])) {
    foreach ($array['sorting'] as $sort) {
        switch ($sort) {
            case "Newest":
                $sorting = "ORDER BY user_tutor_info.create_date DESC";
                break;
            case "Oldest":
                $sorting = "ORDER BY user_tutor_info.create_date ASC";
                break;
            case "HigherR":
                $sorting = "ORDER BY tbl_rating.rating_no DESC";
                break;
            case "LowestR":
                $sorting = "ORDER BY tbl_rating.rating_no ASC";
                break;
        }
    }
}





// Apply the condition for TutoringLevel only if the array is not empty
if (!empty($array['TutoringLevel'])) {
    $havingConditions[] = "COUNT(DISTINCT complete_user_profile_tutoring_detail.TutoringLevel) = " . count($array['TutoringLevel']);
}

// Apply the condition for AdmissionLevel only if the array is not empty
if (!empty($array['AdmissionLevel'])) {
	
	if($AdmissionLevel_val[0]=="Primary" || $AdmissionLevel_val[0]=="Secondary")
	{
		$havingConditions[] = "COUNT(DISTINCT complete_user_profile_tutoring_detail.AdmissionLevel) = " . count($array['AdmissionLevel']);
	}
	else{
		
		$havingConditions[] = "COUNT(DISTINCT complete_user_profile_tutoring_admission_level.AdmissionLevel) = " . count($array['AdmissionLevel']);
	}

}

// Apply the condition for Tutoring_Grade only if the array is not empty
if (!empty($array['grade'])) {
    $havingConditions[] = "COUNT(DISTINCT complete_user_profile_tutoring_grade_detail.Tutoring_Grade) = " . count($array['grade']);
}

// Apply the condition for qualification only if the array is not empty
if (!empty($array['qualification'])) {
    $havingConditions[] = "COUNT(DISTINCT user_tutor_info.qualification) = " . count($array['qualification']);
}

// Apply the condition for Stream only if the array is not empty
if (!empty($array['stream'])) {
    $havingConditions[] = "COUNT(DISTINCT complete_user_profile_tutoring_admission_stream.Stream) = " . count($array['stream']);
}

// Apply the condition for gender only if the array is not empty
if (!empty($array['gender'])) {
    $havingConditions[] = "COUNT(DISTINCT user_tutor_info.gender) = " . count($array['gender']);
}

// Apply the condition for nationality only if the array is not empty
if (!empty($array['nationality'])) {
    $havingConditions[] = "COUNT(DISTINCT user_tutor_info.nationality) = " . count($array['nationality']);
}

// Apply the condition for tutor status only if the array is not empty
if (!empty($array['tutor_status'])) {
    $havingConditions[] = "COUNT(DISTINCT user_tutor_info.tutor_status) = " . count($array['tutor_status']);
}

// Apply the condition for subjects only if the array is not empty
if (!empty($array['subjects'])) {
    //$havingConditions[] = "COUNT(DISTINCT complete_user_profile_tutoring_tutoring_subjects_detail.Tutoring_ALL_Subjects) = " . count($array['subjects']);
}





// Now, combine all the conditions in HAVING clause
$havingClause = '';
if (!empty($havingConditions)) {
    $havingClause = "HAVING " . implode(" AND ", $havingConditions);
}

// Final SQL query
  $check = "
SELECT DISTINCT user_tutor_info.user_id, 
                user_tutor_info.profile_image, 
                user_tutor_info.age, 
                user_tutor_info.tutor_code, 
                user_tutor_info.personal_statement, 
                user_tutor_info.tutor_tutoring_experience_months, 
                user_tutor_info.tutor_tutoring_experience_years, 
                user_tutor_info.postal_code, 
                user_tutor_info.gra_year, 
                user_tutor_info.OtherCourse_Exam, 
                user_tutor_info.Course_Exam, 
                user_tutor_info.name_of_school, 
                user_tutor_info.flag, 
                user_tutor_info.date_of_year, 
                user_tutor_info.qualification, 
                user_tutor_info.gender, 
                user_tutor_info.nationality, 
                user_tutor_info.tutor_status, 
                user_tutor_info.tuition_type, 
                user_tutor_info.travel_distance, 
                user_tutor_info.lettitude, 
                user_tutor_info.longitude, 
                user_tutor_info.stream
FROM user_tutor_info 
LEFT JOIN complete_user_profile_tutoring_detail 
    ON user_tutor_info.user_id = complete_user_profile_tutoring_detail.user_id
LEFT JOIN complete_user_profile_tutoring_grade_detail 
    ON user_tutor_info.user_id = complete_user_profile_tutoring_grade_detail.user_id
LEFT JOIN complete_user_profile_tutoring_tutoring_subjects_detail 
    ON user_tutor_info.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id
LEFT JOIN complete_user_profile_tutoring_admission_stream 
    ON user_tutor_info.user_id = complete_user_profile_tutoring_admission_stream.user_id
LEFT JOIN complete_user_profile_tutoring_admission_level 
    ON user_tutor_info.user_id = complete_user_profile_tutoring_admission_level.user_id
LEFT JOIN tbl_rating 
    ON user_tutor_info.user_id = tbl_rating.tutor_id
{$whereClause}
GROUP BY user_tutor_info.user_id
{$havingClause}
{$sorting}
";





			
			
			$check_res = $conn->query($check);
			
			 $check_res_num = mysqli_num_rows($check_res);
			 
			 
			 //echo '==='.$check_res_num.'==';
			
		  if($check_res_num > 0)	
		  {
			  
			  $Response = array();
				
				while($Filter_Data = mysqli_fetch_assoc($check_res))
				{
					$profile_history_academy_data_array = array();
					$profile_history_academy_result_data_array = array();
					$profile_tutoring_detail_result_data_array = array();
					$complete_user_profile_tutoring_grade_detail_array = array();
					$complete_user_profile_tutoring_tutoring_subjects_detail = array();
					$tutoring_subjects_detail_result_data_array = array();
					
					$lat = $Filter_Data['lettitude'];
					$long = $Filter_Data['longitude'];
					
					//echo $distance_value = distance($student_lat, $student_long, $lat, $long, "K") . " Kilometers<br>";
					 $distance_value = distance($student_lat, $student_long, $lat, $long, "K");

					//echo $distance_value.'<br>';



					// profile_history_academy start

					
						$profile_history_academy = $conn->query("SELECT * FROM complete_user_profile_history_academy WHERE user_id = '".$Filter_Data['user_id']."' ");		
						
						while($profile_history_academy_data = mysqli_fetch_array($profile_history_academy))
						{
							$profile_history_academy_data_array[] = array(
																		'history_academy_id' => $profile_history_academy_data['history_academy_id'],
																		'record_id' => $profile_history_academy_data['record_id'],
																		'school' => $profile_history_academy_data['school'],
																		'exam' => $profile_history_academy_data['exam'],
																		'user_id' => $profile_history_academy_data['user_id']
																		);
						}
						

					// profile_history_academy end	
					
					
					// complete_user_profile_history_academy_result start

					
						$profile_history_academy_result = $conn->query("SELECT * FROM complete_user_profile_history_academy_result WHERE user_id = '".$Filter_Data['user_id']."' ");		
						
						while($profile_history_academy_result_data = mysqli_fetch_array($profile_history_academy_result))
						{
							$profile_history_academy_result_data_array[] = array(
																				'history_academy_result_id' => $profile_history_academy_result_data['history_academy_result_id'],
																				'record_id' => $profile_history_academy_result_data['record_id'],
																				'subject' => $profile_history_academy_result_data['subject'],
																				'grade' => $profile_history_academy_result_data['grade'],
																				'user_id' => $profile_history_academy_result_data['user_id']
																				);
						}
						

					// complete_user_profile_history_academy_result end	
					
					
					// profile_tutoring_detail_result start

					
						$profile_tutoring_detail_result = $conn->query("SELECT * FROM complete_user_profile_tutoring_detail WHERE user_id = '".$Filter_Data['user_id']."' ");		
						
						while($profile_tutoring_detail_result_data = mysqli_fetch_array($profile_tutoring_detail_result))
						{
							
							
							//////
							
							
							
							if($profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'] !="" && empty($array['TutoringLevel']))
							{

							
							$string = $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'];
							$wordsArray = $array['subjects'];

							$found = false;
							foreach ($wordsArray as $word) {
								if (str_contains($string, $word)) {
									$found = true;
									//echo "The word '$word' was found in the string.<br>";
								

							

								$profile_tutoring_detail_result_data_array[] = array(
											
										'tutoring_detail_id' => $profile_tutoring_detail_result_data['tutoring_detail_id'],
										'TutoringLevel' => $profile_tutoring_detail_result_data['TutoringLevel'],
										'AdmissionLevel' => $profile_tutoring_detail_result_data['AdmissionLevel'],
										'Tutoring_Grade' => $profile_tutoring_detail_result_data['Tutoring_Grade'],
										'Tutoring_ALL_Subjects' => $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'],
										'Tutoring_Year' => $profile_tutoring_detail_result_data['Tutoring_Year'],
										'Tutoring_Month' => $profile_tutoring_detail_result_data['Tutoring_Month'],
										'user_id' => $profile_tutoring_detail_result_data['user_id']
										
										);

							}	




						}




						}
						
						
						
						
						
						
						if($profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'] !="" && !empty($array['TutoringLevel']))
						{
							

							///Level search
								
							$wordsArray2 = $array['TutoringLevel'];
							$word2 = $profile_tutoring_detail_result_data['TutoringLevel'];

							if (in_array(strtolower($word2), array_map('strtolower', $wordsArray2))) {
								 $Find_Level = $word2;
							} 

							
							//echo $Find_Level;

							
							$string = $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'];
							$wordsArray = $array['subjects'];

							$found = false;
							foreach ($wordsArray as $word) {
								if (str_contains($string, $word)) {
									$found = true;
									//echo "The word '$word' was found in the string.<br>";
								
								if($word2 == $Find_Level)
								{	

								$profile_tutoring_detail_result_data_array[] = array(
											
										'tutoring_detail_id' => $profile_tutoring_detail_result_data['tutoring_detail_id'],
										'TutoringLevel' => $word2,
										'AdmissionLevel' => $profile_tutoring_detail_result_data['AdmissionLevel'],
										'Tutoring_Grade' => $profile_tutoring_detail_result_data['Tutoring_Grade'],
										'Tutoring_ALL_Subjects' => $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'],
										'Tutoring_Year' => $profile_tutoring_detail_result_data['Tutoring_Year'],
										'Tutoring_Month' => $profile_tutoring_detail_result_data['Tutoring_Month'],
										'user_id' => $profile_tutoring_detail_result_data['user_id']
										
										);
								}		

							}	




						}

						


						}
							
							
							
							//////
							
							
							/**
							$string = $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'];
								$wordsArray = $array['subjects'];

								$found = false;
								foreach($wordsArray as $word) 
								{
									if(str_contains($string, $word)) 
									{
										$found = true;
							        //echo $word;
							
							$profile_tutoring_detail_result_data_array[] = array(
																				'tutoring_detail_id' => $profile_tutoring_detail_result_data['tutoring_detail_id'],
																				'TutoringLevel' => $profile_tutoring_detail_result_data['TutoringLevel'],
																				'AdmissionLevel' => $profile_tutoring_detail_result_data['AdmissionLevel'],
																				'Tutoring_Grade' => $profile_tutoring_detail_result_data['Tutoring_Grade'],
																				'Tutoring_ALL_Subjects' => $profile_tutoring_detail_result_data['Tutoring_ALL_Subjects'],
																				'Tutoring_Year' => $profile_tutoring_detail_result_data['Tutoring_Year'],
																				'Tutoring_Month' => $profile_tutoring_detail_result_data['Tutoring_Month'],
																				'user_id' => $profile_tutoring_detail_result_data['user_id']
																				);
																				
									}

								}	

							**/














								
						}
						

					// profile_tutoring_detail_result end


					

					// complete_user_profile_tutoring_grade_detail start

					
						$complete_user_profile_tutoring_grade_detail_result = $conn->query("SELECT * FROM complete_user_profile_tutoring_grade_detail WHERE user_id = '".$Filter_Data['user_id']."' ");		
						
						while($complete_user_profile_tutoring_grade_detail_result_data = mysqli_fetch_array($complete_user_profile_tutoring_grade_detail_result))
						{
							$complete_user_profile_tutoring_grade_detail_array[] = array(
																						'tutoring_grade_detail_id' => $complete_user_profile_tutoring_grade_detail_result_data['tutoring_grade_detail_id'],
																						'Tutoring_Grade' => $complete_user_profile_tutoring_grade_detail_result_data['Tutoring_Grade'],
																						'user_id' => $complete_user_profile_tutoring_grade_detail_result_data['user_id']
																						
																						);
						}
						

					// complete_user_profile_tutoring_grade_detail end	



					// complete_user_profile_tutoring_tutoring_subjects_detail start

					
						$tutoring_subjects_detail_result = $conn->query("SELECT * FROM complete_user_profile_tutoring_tutoring_subjects_detail WHERE Tutoring_ALL_Subjects = '".$Filter_Data['Tutoring_ALL_Subjects']."' ");		
						
						
						while($tutoring_subjects_detail_result_data = mysqli_fetch_array($tutoring_subjects_detail_result))
						{
							$tutoring_subjects_detail_result_data_array[] = array(
																						'tutoring_subject_detail_id' => $tutoring_subjects_detail_result_data['tutoring_subject_detail_id'],
																						'Tutoring_ALL_Subjects' => $tutoring_subjects_detail_result_data['Tutoring_ALL_Subjects'],
																						'user_id' => $tutoring_subjects_detail_result_data['user_id']
																						
																						);
						}
						

					// complete_user_profile_tutoring_tutoring_subjects_detail end			

					
					$user_main_data = mysqli_fetch_array($conn->query("select * from user_info where user_id = '".$Filter_Data['user_id']."' "));
					
					
					
					if($distance_value <= $Filter_Data['travel_distance'])  /// till 50 km
					{		
                      
                      
					  if($logged_in_student_id !="")
					  {
						  $tutor_favrourite_val = mysqli_fetch_array($conn->query("SELECT * FROM favourite_tutor_by_student WHERE tutor_id = '".$Filter_Data['user_id']."' and logged_in_student_id = '".$logged_in_student_id."' "));
						  
						  $favourite_val = $tutor_favrourite_val['favourite'];
					  }
					  else{
						  $favourite_val = 'false';
					  }
                      
					  if($favourite_val==null || $favourite_val=="")
					  {
						  $favourite_val = 'false';
					  }
                      
					 
					 
					 ///// Rating
					 
					  $rating_val = mysqli_fetch_array($conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Filter_Data['user_id']."' "));
						
						if($rating_val['rating_no'] == null || $rating_val['rating_no'] =="")		
						{
							$rating_val_f = 0;
						}
						else{
							$rating_val_f = $rating_val['rating_no'];
						}
                      
					  
					  
					  
					   //// Average Rating of student_date_time_offer_confirmation
					
					
					$avg_rating_sql = $conn->query("SELECT * FROM tbl_rating WHERE tutor_id = '".$Filter_Data['user_id']."' ");
					
					
					
					$nn = 0;
					$sn = 0;
					while($avg_rating = mysqli_fetch_array($avg_rating_sql))
					{
						$sn = $sn+1;
						$nn = $nn+$avg_rating['rating_no'];
					}
					
					
					if($nn !=0 && $sn !=0)
					{
						
						 $avg_rating = round($nn/$sn); 
					}
					else
					{
						 $avg_rating = 'No rating.';
					}
					 
					  
					  
					  $chk_account_not_suspended = $conn->query("SELECT user_id FROM tbl_user_suspended WHERE user_id = '".$Filter_Data['user_id']."' and account_suspended = 'suspended' ");
					  
							  if(mysqli_num_rows($chk_account_not_suspended)==0)
							  {
								  
								  
								 
								if($Filter_Data['user_id'] != $logged_in_student_id)
								{
							  
								
									$Response[] = array(
														'user_id' => $Filter_Data['user_id'],
														'first_name' => $user_main_data['first_name'],
														'last_name' => $user_main_data['last_name'],
														'favourite' => $favourite_val,
														'rating_val' => $rating_val_f,
														'Average_rating' => $avg_rating,
														'email' => $user_main_data['email'],
														'mobile' => $user_main_data['mobile'],
														'address1' => $user_main_data['address1'],
														'age' => $Filter_Data['age'],
														'profile_image' => $Filter_Data['profile_image'],
														'flag' => $Filter_Data['flag'],
														'personal_statement' => $Filter_Data['personal_statement'],
														'tutor_code' => $Filter_Data['tutor_code'],
														'gender' => $Filter_Data['gender'],
														'nationality' => $Filter_Data['nationality'],
														'qualification' => $Filter_Data['qualification'],
														'tutor_status' => $Filter_Data['tutor_status'],
														'tuition_type' => $Filter_Data['tuition_type'],
														'postal_code' => $Filter_Data['postal_code'],
														'travel_distance' => $Filter_Data['travel_distance'],
														'lettitude' => $Filter_Data['lettitude'],
														'longitude' => $Filter_Data['longitude'],
														'stream' => $Filter_Data['stream'],
														'between_distance' => $distance_value.' KM',
														'profile_history_academy_data_array' => $profile_history_academy_data_array,
														'profile_history_academy_result_data_array' => $profile_history_academy_result_data_array,
														'profile_tutoring_detail_result_data_array' => $profile_tutoring_detail_result_data_array,
														'complete_user_profile_tutoring_grade_detail_array' => $complete_user_profile_tutoring_grade_detail_array,
														'tutoring_subjects_detail_result_data_array' => $tutoring_subjects_detail_result_data_array
														
														
														);
													
													
								}				
											
											
							}
						else{
							$resultData = array('status' => false, 'message' => 'No record found.' );
						}	

					
											
					}
					else{
						$resultData = array('status' => false, 'message' => 'No record found.' );
					}	
						
					
					
					
				}
				
				
				if(!empty($Response))
				{
					$resultData = array('status' => true, 'Search_Data_Records' => $Response);
				}
				else{
					$resultData = array('status' => false, 'message' => 'No Records Found.');
				}
				
			
		  }
		  else{
			
				$resultData = array('status' => false, 'message' => 'No Record Found.');
							
		  }
		
		
		}
		else{ 

			$resultData = array('status' => false, 'message' => 'Please Check The Passive Value.');
		}		
				
			echo json_encode($resultData);
			
?>