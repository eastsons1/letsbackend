<?php
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST");

// Include your database configuration
require_once("config.php");


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
			
			'MCAT' => ['MCAT', 'Biology', 'Chemistry', 'Physics', 'Psychology', 'Sociology' ],
			'Biology' => ['MCAT', 'Biology', 'Chemistry', 'Physics', 'Psychology', 'Sociology' ],
			'Chemistry' => ['MCAT', 'Biology', 'Chemistry', 'Physics', 'Psychology', 'Sociology' ],
			'Physics' => ['MCAT', 'Biology', 'Chemistry', 'Physics', 'Psychology', 'Sociology' ],
			'Psychology' => ['MCAT', 'Biology', 'Chemistry', 'Physics', 'Psychology', 'Sociology' ],
			'Sociology' => ['MCAT', 'Biology', 'Chemistry', 'Physics', 'Psychology', 'Sociology' ],

			'GMAT' => [ 'GMAT', 'Quantitative Reasoning', 'Verbal Reasoning', 'Integrated Reasoning', 'Analytical Writing' ],
			'Quantitative Reasoning' => [ 'GMAT', 'Quantitative Reasoning', 'Verbal Reasoning', 'Integrated Reasoning', 'Analytical Writing' ],
			'Verbal Reasoning' => [ 'GMAT', 'Quantitative Reasoning', 'Verbal Reasoning', 'Integrated Reasoning', 'Analytical Writing' ],
			'Integrated Reasoning' => [ 'GMAT', 'Quantitative Reasoning', 'Verbal Reasoning', 'Integrated Reasoning', 'Analytical Writing' ],
			'Analytical Writing' => [ 'GMAT', 'Quantitative Reasoning', 'Verbal Reasoning', 'Integrated Reasoning', 'Analytical Writing' ],


			'English' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
			'IELTS' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
			'Theory of Knowledge TOK' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
			'TOEFL' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
			'Project Work PW' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
			'General Paper GP' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
			'Literature' => ['English', 'Literature', 'Theory of Knowledge TOK', 'IELTS', 'TOEFL', 'Project Work PW', 'General Paper GP'],
			
			'Math' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
			'Mathematics' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
			'Mathematics H1' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
			'Mathematics H2' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
			'Mathematics HL' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
			'Mathematics SL' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
			'Statistics' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
			'Mathematics H3' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
			'Further Mathematics' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
			'Additional Math' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
			'Math Foundation' => ['Math', 'Math Foundation', 'Mathematics', 'Mathematics H1', 'Mathematics H2', 'Mathematics HL', 'Mathematics SL', 'Statistics', 'Mathematics H3', 'Further Mathematics', 'Additional Math'],
			
			
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
		
		

// Function to calculate distance between two coordinates (in km)
function distance($lat1, $lon1, $lat2, $lon2, $unit) {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $dist = $dist * 60 * 1.1515;
    if ($unit == "K") {
        return $dist * 1.609344; // Convert to kilometers
    } else {
        return $dist;
    }
}

// Read input data
$data = file_get_contents("php://input");
$array = json_decode($data, true);

// Initialize arrays to store conditions
$conditions1 = [];
$conditions2 = [];
$conditions4 = [];
$student_lat = $array['student_lat'];
$student_long = $array['student_long'];
$gender = $array['gender'];
$nationality = $array['nationality'];
$qualification = $array['qualification'];
$tutor_status = $array['tutor_status'];
$logged_in_student_id = $array['logged_in_student_id'];



if(!empty($array['student_lat']) && !empty($array['student_long']) && !empty($array['postal_code']) ) 
{


// Loop through StudentDetail and process based on ID
foreach ($array['StudentDetail'] as $student) {
	
	 if (isset($student['ID'])) {
		  // Check if the ID is 1 (Secondary, Sec 3 condition)
	if ($student['ID'] == "1") {
    if (!empty($student['TutoringLevel']) && !empty($student['AdmissionLevel']) && !empty($student['stream']) && !empty($student['subjects']) && empty($student['grade'])) {
        // Use FIND_IN_SET for TutoringLevel and AdmissionLevel
        $tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
        $admissionLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['AdmissionLevel'])) . "'";
		$stream = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['stream'])) . "'";
		 
        // Check if stream and subjects are provided
        if (!empty($student['stream']) && !empty($student['subjects'])) {
            // Handle subject mappings
            $conditions = [];
            foreach ($student['subjects'] as $subject) {
                if (isset($subjectMappings[$subject])) {
                    // For mapped subjects, generate conditions for all mapped subjects
                    $mappedSubjects = $subjectMappings[$subject];
                    foreach ($mappedSubjects as $mappedSubject) {
                        $safeMappedSubject = $conn->real_escape_string($mappedSubject);
                        $conditions[] = "FIND_IN_SET('$safeMappedSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
                    }
                } else {
                    // For unmapped subjects, use the subject directly
                    $safeSubject = $conn->real_escape_string($subject);
                    $conditions[] = "FIND_IN_SET('$safeSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
                }
            }

            // Combine all conditions into a single string
            $subjectCondition = implode(" OR ", $conditions);

            // Combine subject condition with stream and other conditions
            $conditions1[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels)
                                AND FIND_IN_SET($admissionLevels, complete_user_profile_tutoring_detail.AdmissionLevel) > 0
                                AND FIND_IN_SET($stream, complete_user_profile_tutoring_detail.Stream) > 0
                                AND ($subjectCondition))";
        } else {
            // Handle case when stream or subjects are not provided
            $conditions1[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels)
                                AND FIND_IN_SET($admissionLevels, complete_user_profile_tutoring_detail.AdmissionLevel) > 0)";
        }
    }
}
	
	
	
   /**
        // Check if the ID is 1 (Secondary, Sec 3 condition)
        if ($student['ID'] == "1") {
            if (!empty($student['TutoringLevel']) && !empty($student['AdmissionLevel']) && !empty($student['stream']) && !empty($student['subjects']) && empty($student['grade'])) {
                // Use FIND_IN_SET for AdmissionLevel
                $tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
                $admissionLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['AdmissionLevel'])) . "'";

                
				// Check if stream is provided
                if (!empty($student['stream']) && !empty($student['subjects'])) {
                    $stream = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['stream'])) . "'";
                    $subjects = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['subjects'])) . "'";
					$conditions1[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
                                    AND FIND_IN_SET($admissionLevels, complete_user_profile_tutoring_detail.AdmissionLevel) > 0
                                    AND FIND_IN_SET($stream, complete_user_profile_tutoring_detail.Stream) > 0
									AND FIND_IN_SET($subjects, complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0)";
                } else {
                    $conditions1[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
                                    AND FIND_IN_SET($admissionLevels, complete_user_profile_tutoring_detail.AdmissionLevel) > 0)";
                }
			
			}
        }
		
		
		

        // Check if the ID is 2 (AEIS, Primary condition)
        if ($student['ID'] == "2") {
            if (!empty($student['TutoringLevel']) && !empty($student['AdmissionLevel'])) {
                // Use FIND_IN_SET for AdmissionLevel
                $tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
                $admissionLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['AdmissionLevel'])) . "'";

                // Process the grade condition
                if (!empty($student['grade']) && !empty($student['subjects'])) {
                    $GradeArr = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['grade'])) . "'";
					$subjects = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['subjects'])) . "'";                   
				   $conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
                                    AND FIND_IN_SET($admissionLevels, complete_user_profile_tutoring_detail.AdmissionLevel) > 0
                                    AND FIND_IN_SET($GradeArr, complete_user_profile_tutoring_detail.Tutoring_Grade) > 0
									AND FIND_IN_SET($subjects, complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0)";
                } else {
                    $conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
                                    AND FIND_IN_SET($admissionLevels, complete_user_profile_tutoring_detail.AdmissionLevel) > 0)";
                }
            }
        }
		
		**/
		
		
		if ($student['ID'] == "2") {
			if (!empty($student['TutoringLevel']) && !empty($student['AdmissionLevel'])) {
				// Use FIND_IN_SET for AdmissionLevel
				$tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
				$admissionLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['AdmissionLevel'])) . "'";

				// Process the grade condition
				if (!empty($student['grade']) && !empty($student['subjects'])) {
					$GradeArr = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['grade'])) . "'";
					$conditions = [];
					foreach ($student['subjects'] as $subject) {
						if (isset($subjectMappings[$subject])) {
							// For mapped subjects, generate conditions for all mapped subjects
							$mappedSubjects = $subjectMappings[$subject];
							foreach ($mappedSubjects as $mappedSubject) {
								$safeMappedSubject = $conn->real_escape_string($mappedSubject);
								$conditions[] = "FIND_IN_SET('$safeMappedSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
							}
						} else {
							// For unmapped subjects, use the subject directly
							$safeSubject = $conn->real_escape_string($subject);
							$conditions[] = "FIND_IN_SET('$safeSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
						}
					}

					// Combine all conditions into a single string for subjects
					$subjectCondition = implode(" OR ", $conditions);

					// Combine subject condition with grade, tutoring level, and admission level conditions
					$conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
										AND FIND_IN_SET($admissionLevels, complete_user_profile_tutoring_detail.AdmissionLevel) > 0
										AND FIND_IN_SET($GradeArr, complete_user_profile_tutoring_detail.Tutoring_Grade) > 0
										AND ($subjectCondition))";
				} else {
					// Handle case when grade or subjects are not provided
					$conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
										AND FIND_IN_SET($admissionLevels, complete_user_profile_tutoring_detail.AdmissionLevel) > 0)";
				}
			}
		}


		// Check if the ID is 3 (AEIS, Primary condition)
		if ($student['ID'] == "3") {
			if (!empty($student['TutoringLevel']) && empty($student['AdmissionLevel'])) {
				// Use FIND_IN_SET for TutoringLevel
				$tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";

				// Process the grade condition
				if (!empty($student['grade']) && !empty($student['subjects'])) {
					$GradeArr = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['grade'])) . "'";
					$conditions = [];
					foreach ($student['subjects'] as $subject) {
						if (isset($subjectMappings[$subject])) {
							// For mapped subjects, generate conditions for all mapped subjects
							$mappedSubjects = $subjectMappings[$subject];
							foreach ($mappedSubjects as $mappedSubject) {
								$safeMappedSubject = $conn->real_escape_string($mappedSubject);
								$conditions[] = "FIND_IN_SET('$safeMappedSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
							}
						} else {
							// For unmapped subjects, use the subject directly
							$safeSubject = $conn->real_escape_string($subject);
							$conditions[] = "FIND_IN_SET('$safeSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
						}
					}

					// Combine all conditions into a single string for subjects
					$subjectCondition = implode(" OR ", $conditions);

					// Combine subject condition with grade and tutoring level conditions
					$conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
										AND FIND_IN_SET($GradeArr, complete_user_profile_tutoring_detail.Tutoring_Grade) > 0
										AND ($subjectCondition))";
				} else {
					// Handle case when grade or subjects are not provided
					$conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels))";
				}
			}
		}
		
		
		
		// Check if the ID is 4 (Entrance Exams condition)
		if ($student['ID'] == "4") {
			if (!empty($student['TutoringLevel']) && empty($student['AdmissionLevel']) && empty($student['grade']) && empty($student['stream']) && !empty($student['subjects'])) {
				// Use FIND_IN_SET for TutoringLevel
				$tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";

				// Process the subject condition
				if (!empty($student['subjects'])) {
					$conditions = [];
					foreach ($student['subjects'] as $subject) {
						if (isset($subjectMappings[$subject])) {
							// For mapped subjects, generate conditions for all mapped subjects
							$mappedSubjects = $subjectMappings[$subject];
							foreach ($mappedSubjects as $mappedSubject) {
								$safeMappedSubject = $conn->real_escape_string($mappedSubject);
								$conditions[] = "FIND_IN_SET('$safeMappedSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
							}
						} else {
							// For unmapped subjects, use the subject directly
							$safeSubject = $conn->real_escape_string($subject);
							$conditions[] = "FIND_IN_SET('$safeSubject', complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0";
						}
					}

					// Combine all conditions into a single string for subjects
					$subjectCondition = implode(" OR ", $conditions);

					// Combine subject condition with tutoring level conditions
					$conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
										AND ($subjectCondition))";
				} else {
					// Handle case when subjects are not provided
					$conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels))";
				}
			}
		}


		
		/**
		// Check if the ID is 3 (AEIS, Primary condition)
        if ($student['ID'] == "3") {
            if (!empty($student['TutoringLevel']) && empty($student['AdmissionLevel'])) {
                // Use FIND_IN_SET for AdmissionLevel
                $tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
                

                // Process the grade condition
                if (!empty($student['grade']) && !empty($student['subjects'])) {
                    $GradeArr = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['grade'])) . "'";
					$subjects = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['subjects'])) . "'";                   
				   $conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
                                    AND FIND_IN_SET($GradeArr, complete_user_profile_tutoring_detail.Tutoring_Grade) > 0
									AND FIND_IN_SET($subjects, complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0)";
                } else {
                    $conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) )";
                }
            }
        }
		
		
		
			// Check if the ID is 4 (Entrance Exams condition)
        if ($student['ID'] == "4") {
            if (!empty($student['TutoringLevel']) && empty($student['AdmissionLevel']) && empty($student['grade']) && empty($student['stream']) && !empty($student['subjects'])) {
                // Use FIND_IN_SET for AdmissionLevel
                $tutoringLevels = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['TutoringLevel'])) . "'";
                

                // Process the grade condition
                if (!empty($student['subjects'])) {
                    
					$subjects = "'" . implode("','", array_map([$conn, 'real_escape_string'], $student['subjects'])) . "'";                   
				   $conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) 
									AND FIND_IN_SET($subjects, complete_user_profile_tutoring_detail.Tutoring_ALL_Subjects) > 0)";
                } else {
                    $conditions2[] = "(complete_user_profile_tutoring_detail.TutoringLevel IN ($tutoringLevels) )";
                }
            }
        }
		
		**/
		
		
    }
}

// Get tutor information and filter by distance
$sql_Q = $conn->query("SELECT tuition_type, user_id, lettitude, longitude, travel_distance FROM user_tutor_info");
$tutor_ids = [];

while ($get_Data = mysqli_fetch_assoc($sql_Q)) {
    if (!empty($get_Data['lettitude']) && !empty($get_Data['longitude'])) {
        // Calculate the distance between student and tutor
        $distance_value = distance($student_lat, $student_long, $get_Data['lettitude'], $get_Data['longitude'], "K");

        // Check if the tutor's distance is within the acceptable range
        if ((int)$distance_value <= (int)$get_Data['travel_distance']) {
            $tutor_ids[] = $get_Data['user_id'];
        }
    }
}

// If any tutors are found within the range, add the condition to SQL query
if (!empty($tutor_ids)) {
    $conditions4[] = "user_tutor_info.user_id IN ('" . implode("','", $tutor_ids) . "')";
}

if(!empty($gender)) 
{
	$conditions5[] = "user_tutor_info.gender IN ('" . implode("','", $gender) . "')";
}

if(!empty($nationality)) 
{
	$conditions6[] = "user_tutor_info.nationality IN ('" . implode("','", $nationality) . "')";
}

if(!empty($qualification)) 
{
	$conditions7[] = "user_tutor_info.qualification IN ('" . implode("','", $qualification) . "')";
}
if(!empty($tutor_status)) 
{
	$conditions8[] = "user_tutor_info.tutor_status IN ('" . implode("','", $tutor_status) . "')";
}


// Combine $conditions1 and $conditions2 with OR
$combinedConditions = '';

if (!empty($conditions1) && !empty($conditions2)) {
    // Combine conditions1 and conditions2 with OR
    $combinedConditions = "(" . implode(' OR ', $conditions1) . ") OR (" . implode(' OR ', $conditions2) . ")";
} else {
    // If only conditions1 or conditions2 exist
    if (!empty($conditions1)) {
        $combinedConditions = implode(' OR ', $conditions1);
    }
    if (!empty($conditions2)) {
        $combinedConditions .= (empty($combinedConditions) ? "" : " OR ") . implode(' OR ', $conditions2);
    }
}

// Add $conditions4 with AND
$whereClause = $combinedConditions;

if (!empty($conditions4)) {
    $whereClause .= (empty($whereClause) ? "" : " AND ") . implode(' AND ', $conditions4);
}
if (!empty($conditions5)) {
    $whereClause .= (empty($whereClause) ? "" : " AND ") . implode(' AND ', $conditions5);
}
if (!empty($conditions6)) {
    $whereClause .= (empty($whereClause) ? "" : " AND ") . implode(' AND ', $conditions6);
}
if (!empty($conditions7)) {
    $whereClause .= (empty($whereClause) ? "" : " AND ") . implode(' AND ', $conditions7);
}
if (!empty($conditions8)) {
    $whereClause .= (empty($whereClause) ? "" : " AND ") . implode(' AND ', $conditions8);
}




		
			// Handle sorting
			$sorting = "";
			if (!empty($array['sorting'])) {
				foreach ($array['sorting'] as $sort) {
					switch ($sort) {
						case "Newest":
							$sorting = " ORDER BY user_tutor_info.create_date DESC";
							break;
						case "Oldest":
							$sorting = " ORDER BY user_tutor_info.create_date ASC";
							break;
						case "HigherR":
							$sorting = " ORDER BY tbl_rating.rating_no DESC";
							break;
						case "LowestR":
							$sorting = " ORDER BY tbl_rating.rating_no ASC";
							break;
					}
				}
			}



			// Construct the full SQL query
			echo $sql = "
				SELECT DISTINCT 
					user_tutor_info.user_id, 
					user_tutor_info.profile_image, 
					user_tutor_info.age, 
					user_tutor_info.tutor_code, 
					user_tutor_info.personal_statement, 
					user_tutor_info.tutor_tutoring_experience_months, 
					user_tutor_info.tutor_tutoring_experience_years, 
					user_tutor_info.postal_code, 
					user_tutor_info.gra_year, 
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
				LEFT JOIN complete_user_profile_tutoring_tutoring_subjects_detail 
					ON user_tutor_info.user_id = complete_user_profile_tutoring_tutoring_subjects_detail.user_id
				LEFT JOIN complete_user_profile_tutoring_detail 
					ON user_tutor_info.user_id = complete_user_profile_tutoring_detail.user_id
				LEFT JOIN complete_user_profile_tutoring_grade_detail 
					ON user_tutor_info.user_id = complete_user_profile_tutoring_grade_detail.user_id
				LEFT JOIN complete_user_profile_tutoring_admission_stream 
					ON user_tutor_info.user_id = complete_user_profile_tutoring_admission_stream.user_id
				LEFT JOIN complete_user_profile_tutoring_admission_level 
					ON user_tutor_info.user_id = complete_user_profile_tutoring_admission_level.user_id
				LEFT JOIN tbl_rating 
					ON user_tutor_info.user_id = tbl_rating.tutor_id	
				WHERE $whereClause  $sorting
			";
			

			// Execute the query
			$result = $conn->query($sql);

			// Check if any results are returned
			if ($result && $result->num_rows > 0) {
				$output = [];
				while ($row = $result->fetch_assoc()) {
					$output[] = $row;
				}
				// Send response with data
				
				 
				 if (!empty($output)) {
						$resultData = array('status' => true, 'Search_Data_Records' => $output);
					} else {
						$resultData = array('status' => false, 'message' => 'No Records Found.');
					}	
				 
				 
			} else {
				// No tutors found
				$resultData = array('status' => false, 'message' => 'No Records Found.');
			}


}
else{ 

		$resultData = array('status' => false, 'message' => 'Please Check The Passive Value.');
	}		
			
			
		echo json_encode($resultData);
			
		
?>
