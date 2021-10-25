<?php
class TwytModel{
   
    private $twytId;
    private $twytText;
    private $twytUserScreenName;
    private $twytUserUrl;
    private $twytCreatedAt;
    private $twytProfileImage;

    public function __construct($twytId,$twytText,$twytUserScreenName,$twytUserUrl,$twytCreatedAt,$twytProfileImage)
    {
        $this->twytId = $twytId;
        $this->twytText = $twytText;
        $this->twytUserScreenName = $twytUserScreenName;
        $this->twytUserUrl = $twytUserUrl??null; 
        $this->twytCreatedAt = $twytCreatedAt;
        $this->twytProfileImage = $twytProfileImage??'';
    }

    public function getTwytId()
    {
        return $this->twytId;
    }

    public function getTwytCreatedAt()
    {
        return $this->twytCreatedAt;
    }
    
    public function getTwytText()
    {
        return $this->twytText;
    }
    public function getTwytUserScreenName()
    {
        return $this->twytUserScreenName;
    }
    public function getTwytUserUrl()
    {
        return $this->twytUserUrl;
    }

    public function getTwytProfileImage(){
        return $this->twytProfileImage;
    }
}