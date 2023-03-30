<?php
class KetQuaModel extends DB{
    public function start($made, $manguoidung)
    {
        $valid = true;
        $sql = "INSERT INTO `ketqua`(`made`, `manguoidung`) VALUES ('$made','$manguoidung')";
        $result = mysqli_query($this->con, $sql);
        if(!$result) $valid = false;
        return $valid;
    }

    public function updateChangeTab($made, $manguoidung)
    {
        $solanchuyentab = $this->getChangeTab($made, $manguoidung)['solanchuyentab'];
        $sql = "UPDATE `ketqua` SET `solanchuyentab`='$solanchuyentab' WHERE `made`='$made' AND `manguoidung`='$manguoidung'";
        $valid = true;
        $result = mysqli_query($this->con, $sql);
        if(!$result) $valid = false;
        return $valid;
    }

    public function getChangeTab($made, $manguoidung) {
        $sql = "SELECT `solanchuyentab` FROM `ketqua` WHERE `made`='$made' AND `manguoidung`='$manguoidung'";
        $result = mysqli_query($this->con, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function end($made, $manguoidung, $diemthi, $thoigianlambai, $socaudung)
    {
        $sql = "UPDATE `ketqua` SET `diemthi`='$diemthi',`thoigianlambai`='$thoigianlambai',`socaudung`='$socaudung' WHERE `made`='$made' AND `manguoidung`='$manguoidung'";
    }

    public function getMaKQ($made, $manguoidung)
    {
        $sql = "SELECT `makq` FROM `ketqua` WHERE `made` = '$made' AND `manguoidung` = '$manguoidung'";
        $result = mysqli_query($this->con, $sql);
        return mysqli_fetch_assoc($result);
    }

    public function socaudung($listCauTraLoi){
        $socaudung = 0;
        foreach($listCauTraLoi as $tl){
            $macauhoi = $tl['macauhoi'];
            $cautraloi = $tl['cautraloi'];
            $sql = "SELECT * FROM cautraloi ctl WHERE ctl.macauhoi = '$macauhoi' AND ctl.macautl = '$cautraloi' AND ctl.ladapan = 1";
            $result = mysqli_query($this->con,$sql);
            if(mysqli_num_rows($result)>0) $socaudung++;
        }
        return $socaudung;
    }

    public function submit($made,$nguoidung,$list,$thoigian,$slct){
        $valid = true;
        $socaudung = $this->socaudung($list);
        $socau = count($list);
        $diem = 10/$socau * $socaudung;
        $sql = "UPDATE `ketqua` SET `diemthi`='$diem',`thoigianlambai`='$thoigian',`socaudung`='$socaudung',`solanchuyentab`='$slct' WHERE manguoidung = '$nguoidung' and made = '$made'";
        $result = mysqli_query($this->con,$sql);
        if(!$result) $valid = false;
        return $valid;
    }
}
?>