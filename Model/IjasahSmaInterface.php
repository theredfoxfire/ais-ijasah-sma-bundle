<?php

namespace Ais\IjasahSmaBundle\Model;

Interface IjasahSmaInterface
{
    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set mahasiswaId
     *
     * @param integer $mahasiswaId
     *
     * @return IjasahSma
     */
    public function setMahasiswaId($mahasiswaId);

    /**
     * Get mahasiswaId
     *
     * @return integer
     */
    public function getMahasiswaId();

    /**
     * Set pelajaran
     *
     * @param string $pelajaran
     *
     * @return IjasahSma
     */
    public function setPelajaran($pelajaran);

    /**
     * Get pelajaran
     *
     * @return string
     */
    public function getPelajaran();

    /**
     * Set nilai
     *
     * @param string $nilai
     *
     * @return IjasahSma
     */
    public function setNilai($nilai);

    /**
     * Get nilai
     *
     * @return string
     */
    public function getNilai();

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return IjasahSma
     */
    public function setIsDelete($isDelete);

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete();
}
