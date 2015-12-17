<?php

namespace Ais\IjasahSmaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ais\IjasahSmaBundle\Model\IjasahSmaInterface;
/**
 * IjasahSma
 */
class IjasahSma implements IjasahSmaInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $mahasiswa_id;

    /**
     * @var string
     */
    private $pelajaran;

    /**
     * @var string
     */
    private $nilai;

    /**
     * @var boolean
     */
    private $is_delete;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set mahasiswaId
     *
     * @param integer $mahasiswaId
     *
     * @return IjasahSma
     */
    public function setMahasiswaId($mahasiswaId)
    {
        $this->mahasiswa_id = $mahasiswaId;

        return $this;
    }

    /**
     * Get mahasiswaId
     *
     * @return integer
     */
    public function getMahasiswaId()
    {
        return $this->mahasiswa_id;
    }

    /**
     * Set pelajaran
     *
     * @param string $pelajaran
     *
     * @return IjasahSma
     */
    public function setPelajaran($pelajaran)
    {
        $this->pelajaran = $pelajaran;

        return $this;
    }

    /**
     * Get pelajaran
     *
     * @return string
     */
    public function getPelajaran()
    {
        return $this->pelajaran;
    }

    /**
     * Set nilai
     *
     * @param string $nilai
     *
     * @return IjasahSma
     */
    public function setNilai($nilai)
    {
        $this->nilai = $nilai;

        return $this;
    }

    /**
     * Get nilai
     *
     * @return string
     */
    public function getNilai()
    {
        return $this->nilai;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return IjasahSma
     */
    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete()
    {
        return $this->is_delete;
    }
}
