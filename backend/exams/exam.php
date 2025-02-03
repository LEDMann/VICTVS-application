<?php

/**
 * Exam Class for parsing and formatting the objects passed to it when the file is loaded
 * 
 * @uses JsonSerializable for the jsonSerialize function allowing this class to be automatically serialised into json when it is returned to the client
 * 
 * @param int $id                   the id of the exam
 * @param string $Title             the title of the exam
 * @param string $Description       the description for the exam
 * @param int $Candidateid          the id of the candidate of this exam
 * @param string $CandidateName     the name of the candidate of this exam
 * @param DateTime $Date            the date of the exam
 * @param string $LocationName      the name of the location of this exam
 * @param float $Latitude           the latitude coordinate for the location of this exam
 * @param float $Longitude          the longitude coordinate for the location of this exam
 * @param float $Distance           the distance in KM of the exam from the users location or the coordinates specified in the get request
 * @param string $DistanceFormatted the formatted distance value to 2 decimal points and with commas as delimiters
 */
class Exam implements JsonSerializable {
    public int $id;
    public string $Title;
    public string $Description;
    public int $Candidateid;
    public string $CandidateName;
    public DateTime $Date;
    public string $LocationName;
    public float $Latitude;
    public float $Longitude;
    public float $Distance;
    public string $DistanceFormatted;

    /**
     * construct an instance of this class by consuming and transforming the values of the $exam value passed to it, 
     * the $ulat and $ulong values are latitude and longitude coordinates that will be calculated with the exams 
     * coordinates to find and store the distance between them
     * 
     * @param Object $exam          a record of an exam with raw values 
     * @param float $ulat           a latitude coordinate for the user
     * @param float $ulong          a longitude coordinate for the user
     */
    function __construct(Object $exam, float $ulat, float $ulong) {
        $this->id = intval($exam->id);
        $this->Title = $exam->Title;
        $this->Description = $exam->Description;
        $this->Candidateid = intval($exam->Candidateid);
        $this->CandidateName = $exam->CandidateName;
        $this->Date = DateTime::createFromFormat('d/m/Y H:i:s', $exam->Date);
        $this->LocationName = $exam->LocationName;
        $this->Latitude = floatval($exam->Latitude);
        $this->Longitude = floatval($exam->Longitude);
        if ($ulat && $ulong) {
            // finds distance in KM between 2 sets of latitude and longitude coordinates
            // does 2R × sin⁻¹(√[sin²((θ₂ - θ₁)/2) + cosθ₁ × cosθ₂ × sin²((φ₂ - φ₁)/2)]) from https://www.omnicalculator.com/other/latitude-longitude-distance
            $lat1 = deg2rad($this->Latitude);
            $lat2 = deg2rad($ulat);
            $long1 = deg2rad($this->Longitude);
            $long2 = deg2rad($ulong);
            $this->Distance = 2*6371*asin(sqrt(sin(($lat2-$lat1)/2)**2+cos($lat1)*cos($lat2)*sin(($long2-$long1)/2)**2));
            $this->DistanceFormatted = number_format($this->Distance, 2, '.', ',');
        } else {
            $this->Distance = -1;
            $this->DistanceFormatted = "N/A";
        }
    }

    /**
     * jsonSerialize function from the JsonSerializable interface implemented to control how this class is serialised to json
     */
    public function jsonSerialize(): Mixed {
        return [
            "id" => $this->id,
            "Title" => $this->Title,
            "Description" => $this->Description,
            "Candidateid" => $this->Candidateid,
            "CandidateName" => $this->CandidateName,
            "Date" => $this->Date->format("H:i:s d-m-Y"),
            "LocationName" => $this->LocationName,
            "Latitude" => $this->Latitude,
            "Longitude" => $this->Longitude,
            "Distance" => $this->Distance,
            "DistanceFormatted" => $this->DistanceFormatted,
        ];
    }
}

?>