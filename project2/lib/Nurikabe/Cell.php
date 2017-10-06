<?php

namespace Nurikabe;


class Cell{
    private $id;
    private $c_row;
    private $c_col;
    private $c_val;
    private $Nurikabeid;

    public function __construct($row)
    {
        $this->id = $row['id'];
        $this->c_row = $row['c_row'];
        $this->c_col = $row['c_col'];
        $this->c_val = $row['c_val'];
        $this->Nurikabeid = $row['Nurikabeid'];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCRow()
    {
        return $this->c_row;
    }

    /**
     * @param mixed $c_row
     */
    public function setCRow($c_row)
    {
        $this->c_row = $c_row;
    }

    /**
     * @return mixed
     */
    public function getCCol()
    {
        return $this->c_col;
    }

    /**
     * @param mixed $c_col
     */
    public function setCCol($c_col)
    {
        $this->c_col = $c_col;
    }

    /**
     * @return mixed
     */
    public function getCVal()
    {
        if(is_numeric($this->c_val)){
            $c_val = (int) $this->c_val;
            return $c_val;
        }
        else {
            return $this->c_val;
        }
    }

    /**
     * @param mixed $c_val
     */
    public function setCVal($c_val)
    {
        $this->c_val = $c_val;
    }

    /**
     * @return mixed
     */
    public function getNurikabeid()
    {
        return $this->Nurikabeid;
    }

    /**
     * @param mixed $Nurikabeid
     */
    public function setNurikabeid($Nurikabeid)
    {
        $this->Nurikabeid = $Nurikabeid;
    }
}