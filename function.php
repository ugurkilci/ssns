<?php

/*
 *
 * Creator: Uğur KILCI
 * Twitter: @ugur2nd
 * Github:     @ugurkilci
 *
 * 31.01.17 / 21.47
 *
 */

session_start();

function Code($b = 6)
// güvenlik kodu
{
    $a = 'ABCDEFGK123456789lmnopzfLMNOPQRSTUVWXYZ';
    return substr(md5(sha1(str_shuffle($a))), 0, $b);
}

function mailkont($mail)
// mail kontrol
{
    if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        return 1;
    } else {
        return 0;
    }
}

$securitycode = md5(rand(111111, 999999)); // Her ihtimale karşı güvenlik kodu

function profile()
{
    include("ayar.php"); // ayar dosyası
    global $edit; // global edit değişkeni
    global $uyeler_kadi; // global değişken
    global $securitycode; // güvenlik kodu
    
    $edit = @$_GET["edit"]; // edit
    $u    = @$_GET["u"]; // username
    
    if ($u) {
        include("ayar.php"); // ayar dosyası
        $cek = $db->prepare("SELECT * FROM uyeler WHERE uyeler_kadi =:uyeler_kadi");
        
        $cek->execute(array(
            'uyeler_kadi' => $u
        ));
        $saydirma = $cek->rowCount();
        
        if ($saydirma > 0) { // Hesap varsa
            $select = $db->prepare("SELECT * FROM uyeler WHERE uyeler_kadi=?");
            $select->execute(array(
                $u
            ));
            $selectx = $select->fetch(PDO::FETCH_ASSOC);
            
            echo '
        <img src="' . $selectx["uyeler_fotograf"] . '" class="img-circle" style="width:128px;height:128px;">
        <h2>' . $selectx["uyeler_kadi"] . '</h2>
        <p>
            <u>Hakkında:</u> ' . $selectx["uyeler_hakkinda"] . '<br />
            <u>E-Posta:</u> ' . $selectx["uyeler_eposta"] . '<br />
            <u>Memleketi:</u> ' . $selectx["uyeler_ulke"] . '<br />
            <u>Cinsiyet:</u> ' . $selectx["uyeler_cinsiyet"] . '<br />
            <u>Doğum Tarihi:</u> ' . $selectx["uyeler_dogumtarihi"] . '<br />
            <u>Üyelik Tarihi:</u> ' . $selectx["uyeler_uyeliktarihi"] . '<br />
        </p>';
            
            $num_rec_per_page = 10; // Ekranda kaç yorum gözüksün?
            
            try {
                if (isset($_GET["page"])) {
                    $page = $_GET["page"];
                } else {
                    $page = 1;
                }
                ;
                
                $start_from = ($page - 1) * $num_rec_per_page;
                $sql        = "SELECT * FROM basliklar WHERE baslik_sahip=? ORDER BY baslik_id DESC LIMIT $start_from, $num_rec_per_page";
                $rs_result  = $db->prepare($sql);
                $rs_result->setFetchMode(PDO::FETCH_ASSOC);
                $rs_result->execute(array(
                    $u
                ));
                
                if ($rs_result->rowCount() > 0) {
                    echo '<ul>';
                    while ($row = $rs_result->fetchObject()) { // Yorum listesi burada olacak
                        echo '
                    <li class="share">
                        <span>' . $row->baslik_begen . ' Like</span> <a href="page?p=' . $row->baslik_baslik_replace . '">' . $row->baslik_baslik . '</a><br />
                        <small><a href="profile?u=' . $row->baslik_sahip . '">' . $row->baslik_sahip . '</a> - <em>' . $row->baslik_tarih . '</em> - <a href="?edit=' . $row->baslik_id . '">Delete!</a></small>
                        <br />
                    </li>
                    ';
                    }
                    echo '</ul>';
                } else {
                    echo "Not shared.<br />"; // Hata Mesajı
                }
            }
            catch (PDOException $pe) {
                echo "<br />Oh, theres something wrong! :(<br />"; // Hata Mesajı
            }
            
            $sql       = "SELECT * FROM basliklar WHERE baslik_sahip=?";
            $rs_result = $db->prepare($sql);
            $rs_result->execute(array(
                $u
            ));
            $total_records = $rs_result->rowCount();
            $total_pages   = ceil($total_records / $num_rec_per_page);
            
            echo '<br /><a href="profile?u=' . $u . '" class="m2">First</a> '; // İlk Sayfa
            
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a href="profile?u=' . $u . '&page=' . $i . '" class="m2">' . $i . '</a> ';
            }
            ;
            
            echo ' <a href="profile?u=' . $u . '&page=' . $total_pages . '" class="m2">Next</a>'; // Sonraki Sayfa
            
        } else {
            /* Hesap yoksa */
            header("REFRESH:0;URL=404");
            /* hata ver */
        }
    } else { // Eğer böyle bir kullanıcı yoksa
        if ($edit) { // Edit yapılıyorsa
            if ($_SESSION) { // giriş yaptıysa
                if (isset($_POST["delete"])) { // Eğer like tuşuna basılmışsa
                    $kod = $_POST["kod"]; // Güvenlik kodu değişkeni
                    
                    if ($kod = $securitycode) { // Eğer kod değişkenin içinde ki veri ile securitycode değişkenin içindeki veri eşitse
                        $delete = $db->prepare("DELETE FROM basliklar WHERE baslik_id=? && baslik_sahip=?");
                        $delete->execute(array(
                            $edit,
                            $uyeler_kadi
                        )); // başlık idsi ve başlık sahibi aynı ise
                        
                        if ($delete) { // delete işlemi çalıştıysa :)
                            echo 'Successfully deleted. :)';
                            header("REFRESH:1;URL=profile"); // profile yönlendir
                        } else { // delete işlemi çalışmadıysa :(
                            echo 'Oh, he could not be removed. :(';
                            header("REFRESH:1;URL=profile"); // profile yönlendir
                        }
                        
                    } else { // Eğer bir farklılık varsa
                        echo 'Your security code is in error and cannot be processed! :S'; // hata mesajı
                    }
                } else {
                    echo '
                    <h1>Do you want to delete the title?</h1>
                    <form aciton="" method="POST">
                        <a href="profile" class="btn m2 add">No! :(</a>
                        <input type="hidden" name="kod" value="' . $securitycode . '" />
                        <input type="submit" name="delete" class="btn m2 add" value="Yes! :)" />
                    </form>';
                }
            } else { // giriş yapmadıysa
                header("REFRESH:0;URL=404"); // 404 yönlendir
            }
        } else {
            if ($_SESSION) { // giriş yaptıysa
                header("REFRESH:0;URL=profile?u=" . $uyeler_kadi); // profile yönlendir
            } else { // giriş yapmadıysa
                header("REFRESH:0;URL=404"); // 404 yönlendir
            }
        }
    }
}

function profile_data()
{
    $u = @$_GET["u"]; // username
    global $s_kadi; // global kadi
    global $s_hakkinda; // global hakkında
    
    if ($u) {
        include("ayar.php"); // ayar dosyası
        
        $cek = $db->prepare("SELECT * FROM uyeler WHERE uyeler_kadi =:uyeler_kadi");
        
        $cek->execute(array(
            'uyeler_kadi' => $u
        ));
        $saydirma = $cek->rowCount();
        
        if ($saydirma > 0) { // Hesap varsa
            $select = $db->prepare("SELECT * FROM uyeler WHERE uyeler_kadi=?");
            $select->execute(array(
                $u
            ));
            $selectx = $select->fetch(PDO::FETCH_ASSOC);
            
            $s_kadi     = $selectx["uyeler_kadi"]; // kullanıcı adı
            $s_hakkinda = $selectx["uyeler_hakkinda"]; // kullanıcı hakkında
            
        } else { // Giriş yapılmamışsa
            header("REFRESH:0;URL=404"); // hata ver
        }
    }
}

function login()
{
    include("ayar.php"); // config
    global $securitycode;
    $uyecek = $db->prepare("SELECT * FROM uyeler WHERE uyeler_kadi=? && uyeler_sifre=?");
    
    if (isset($_POST["login"])) { // giriş yapılmışsa
        $kadi  = htmlspecialchars(trim($_POST["kadi"])); // kullanıcı adı
        $sifre = md5(sha1(htmlspecialchars(trim($_POST["sifre"])))); // şifre
        $kod   = $_POST["kod"]; // kod
        if (empty($kadi) || empty($sifre)) {
            echo 'Please do not leave it blank!';
        } else {
            if ($kod = $securitycode) {
                $uyecek->execute(array(
                    $kadi,
                    $sifre
                ));
                $fetch    = $uyecek->fetch(PDO::FETCH_ASSOC);
                $rowcount = $uyecek->rowCount();
                
                if ($rowcount) {
                    
                    $_SESSION["uyeler_id"]           = $fetch["uyeler_id"]; // üyenin idsi
                    $_SESSION["uyeler_kadi"]         = $fetch["uyeler_kadi"]; // üyenin kullanıcı adı
                    $_SESSION["uyeler_sifre"]        = $fetch["uyeler_sifre"]; // üyenin şifresi
                    $_SESSION["uyeler_eposta"]       = $fetch["uyeler_eposta"]; // üyenin epostası
                    $_SESSION["uyeler_hakkinda"]     = $fetch["uyeler_hakkinda"]; // üye hakkında
                    $_SESSION["uyeler_fotograf"]     = $fetch["uyeler_fotograf"]; // üye fotoğrafı
                    $_SESSION["uyeler_cinsiyet"]     = $fetch["uyeler_cinsiyet"]; // üyenin cinsiyeti
                    $_SESSION["uyeler_dogumtarihi"]  = $fetch["uyeler_dogumtarihi"]; // üyenin doğum tarihi
                    $_SESSION["uyeler_uyeliktarihi"] = $fetch["uyeler_uyeliktarihi"]; // üyenin üyelik tarihi
                    $_SESSION["uyeler_ulke"]         = $fetch["uyeler_ulke"]; // üyenin memleketi
                    $_SESSION["uyeler_rutbe"]        = $fetch["uyeler_rutbe"]; // üyenin rütbesi
                    
                    header("REFRESH:0;URL=home");
                } else {
                    echo 'Username or password is wrong! :S';
                }
            } else {
                echo "Your security code is in error and cannot be processed! :S";
            }
        }
    }
}

function register()
{
    include("ayar.php"); // config
    global $securitycode;
    
    if (isset($_POST["register"])) { // kayıt ol
        $kadi  = htmlspecialchars(trim($_POST["kadi"])); // kullanıcı adı
        $sifre = md5(sha1(htmlspecialchars(trim($_POST["sifre"])))); // sifre
        $mail  = htmlspecialchars(trim($_POST["mail"])); // mail
        $kod   = $_POST["kod"]; // kod
        if (empty($kadi) || empty($sifre) || empty($mail)) { // Boşluk kontrolü
            echo 'Please do not leave it blank! :S';
        } else {
            if ($kod = $securitycode) {
                $kontrol_et = mailkont($mail); // maili kontrol et
                
                if ($kontrol_et == "1") { // mail doğrulama başarılı
                    $sql      = "INSERT INTO uyeler SET uyeler_kadi=?, uyeler_sifre=?, uyeler_eposta=?, uyeler_hakkinda=?, uyeler_fotograf=?, uyeler_cinsiyet=?, uyeler_ulke=?";
                    $register = $db->prepare($sql);
                    $register->execute(array(
                        $kadi,
                        $sifre,
                        $mail,
                        "LOL!",
                        "resimler/photo.jpg",
                        "Belirlenmemiş",
                        "Turkey"
                    ));
                    
                    if ($register) {
                        echo "Success Register! :)";
                        header("REFRESH:1;URL=login");
                    } else {
                        echo "We met with a wrong problem! :S";
                    }
                } else { // mail hatalı ise
                    echo 'This not mail! :S';
                }
            } else {
                echo "Your security code is in error and cannot be processed! :S";
            }
        }
    }
}

$uyeler_id           = @$_SESSION["uyeler_id"]; // üyenin idsi
$uyeler_kadi         = @$_SESSION["uyeler_kadi"]; // üyenin kullanıcı adı
$uyeler_sifre        = @$_SESSION["uyeler_sifre"]; // üyenin şifresi
$uyeler_eposta       = @$_SESSION["uyeler_eposta"]; // üyenin epostası
$uyeler_hakkinda     = @$_SESSION["uyeler_hakkinda"]; // üye hakkında
$uyeler_fotograf     = @$_SESSION["uyeler_fotograf"]; // üye fotoğrafı
$uyeler_cinsiyet     = @$_SESSION["uyeler_cinsiyet"]; // üyenin cinsiyeti
$uyeler_dogumtarihi  = @$_SESSION["uyeler_dogumtarihi"]; // üyenin doğum tarihi
$uyeler_uyeliktarihi = @$_SESSION["uyeler_uyeliktarihi"]; // üyenin üyelik tarihi
$uyeler_ulke         = @$_SESSION["uyeler_ulke"]; // üyenin memleketi
$uyeler_rutbe        = @$_SESSION["uyeler_rutbe"]; // üyenin rütbesi

function settings_one()
// genel ayarlar
{
    include("ayar.php"); // config
    global $uyeler_kadi; // global uyeler_kadi
    
    if (isset($_POST["s_one"])) { // genel ayarlar
        $fotograf    = htmlspecialchars(trim($_POST["uyeler_fotograf"])); // fotograf
        $hakkinda    = htmlspecialchars(trim($_POST["uyeler_hakkinda"])); // hakkinda
        $eposta      = htmlspecialchars(trim($_POST["uyeler_eposta"])); // eposta
        $cinsiyet    = htmlspecialchars(trim($_POST["uyeler_cinsiyet"])); // cinsiyet
        $dogumtarihi = htmlspecialchars(trim($_POST["uyeler_dogumtarihi"])); // dogumtarihi
        $ulke        = htmlspecialchars(trim($_POST["uyeler_ulke"])); // ulke
        $kod         = $_POST["kod"]; // güvenlik kodu
        
        if (empty($fotograf) || empty($hakkinda) || empty($eposta) || empty($cinsiyet) || empty($dogumtarihi) || empty($ulke)) { // Boşluk kontrolü
            echo 'Please do not leave it blank! :S';
        } else {
            if ($securitycode = $kod) {
                $kontrol_et = mailkont($eposta); // maili kontrol et
                
                if ($kontrol_et == "1") { // mail doğrulama başarılı
                    $sql    = "UPDATE uyeler SET uyeler_fotograf=?, uyeler_hakkinda=?, uyeler_eposta=?, uyeler_cinsiyet=?, uyeler_dogumtarihi=?, uyeler_ulke=? WHERE uyeler_kadi=?";
                    $update = $db->prepare($sql);
                    $update->execute(array(
                        $fotograf,
                        $hakkinda,
                        $eposta,
                        $cinsiyet,
                        $dogumtarihi,
                        $ulke,
                        $uyeler_kadi
                    ));
                    
                    if ($update) {
                        echo "Success Update! :)";
                        header("REFRESH:1;URL=settings");
                    } else {
                        echo "We met with a wrong problem! :S";
                    }
                } else { // mail hatalı ise
                    echo 'This not mail! :S';
                }
            } else { // Eğer bir farklılık varsa
                echo 'Your security code is in error and cannot be processed! :S'; // hata mesajı
            }
        }
    }
}

function settings_two()
// genel ayarlar
{
    include("ayar.php"); // config
    global $uyeler_kadi; // global uyeler_kadi
    global $securitycode; // güvenlik kodu
    
    $veri = $db->prepare("SELECT * FROM uyeler WHERE uyeler_kadi=?");
    $veri->execute(array(
        $uyeler_kadi
    ));
    $vericek = $veri->fetch(PDO::FETCH_ASSOC);
    
    if (isset($_POST["s_two"])) { // genel ayarlar
        $sifre     = md5(sha1(htmlspecialchars(trim($_POST["password"])))); // sifre
        $yenisifre = md5(sha1(htmlspecialchars(trim($_POST["newpassword"])))); // yenisifre
        $kod       = $_POST["kod"]; // güvenlik kodu
        if ($kod = $securitycode) {
            if ($vericek["uyeler_sifre"] == $sifre) { // eski şifre doğrula
                if (empty($sifre) || empty($yenisifre)) { // Boşluk kontrolü
                    echo 'Please do not leave it blank! :S';
                } else { // şifre değiştirme
                    $sql    = "UPDATE uyeler SET uyeler_sifre=? WHERE uyeler_kadi=?";
                    $update = $db->prepare($sql);
                    $update->execute(array(
                        $yenisifre,
                        $uyeler_kadi
                    ));
                    
                    if ($update) { // değiştirildi
                        echo "Success Update! :)";
                    } else { // değiştirilmedi
                        echo "We met with a wrong problem! :S";
                    }
                }
            } else { // mail hatalı ise
                echo 'Please enter your existing password correctly! :ı';
            }
        } else { // Eğer bir farklılık varsa
            echo 'Your security code is in error and cannot be processed! :S'; // hata mesajı
        }
    }
}

function exit2()
{
    include("ayar.php"); // config
    
    session_destroy();
    
    header("REFRESH:2;URL=login");
    
    echo 'You are leaving. We wait again. :)<br />';
}

function page()
// başlık çek [sayfa]
{
    global $vericek;
    global $p;
    
    include("ayar.php"); // config
    
    $p = @$_GET["p"]; // page name
    
    $veri = $db->prepare("SELECT * FROM basliklar WHERE baslik_baslik_replace=?");
    $veri->execute(array(
        $p
    ));
    $vericek = $veri->fetch(PDO::FETCH_ASSOC);
}

function like()
// başlığı beğen
{
    global $p; // p değişkenini her yerde kullanabiliriz.
    global $like_code; // like_code değişkenini her yerde kullanabiliriz.
    global $like; // addlike değişkenini her yerde kullanabiliriz.
    global $securitycode; // güvenlik kodu
    
    include("ayar.php"); // ayar dosyası
    
    $p = @$_GET["p"]; // sayfa adı
    
    $like_code = Code(); // likekımızı güvenlik içine aldığımız değişken
    $addlike   = $like + 1; // Şuan ki beğeni sayısına +1 ekledik
    
    if (isset($_POST["like"])) { // Eğer like tuşuna basılmışsa
        $kod = $_POST["kod"]; // Güvenlik kodu değişkeni
        
        if ($kod = $securitycode) { // Eğer kod değişkenin içinde ki veri ile securitycode değişkenin içindeki veri eşitse
            $update = $db->prepare("UPDATE basliklar SET baslik_begen=? WHERE baslik_baslik_replace=?");
            $update->execute(array(
                $addlike,
                $p
            ));
            
            if ($update) { // Güncelleme işlemi başarılı ise
                echo '<br />It was like successfully. :)<br />';
            } else { // Güncelleme işlemi başarısız ise
                echo '<br />Oh, theres something wrong! :(<br />'; // Hata mesajı
            }
        } else { // Eğer veriler eşit değilse
            echo 'Oh, theres something wrong! :(<br />'; // Hata mesajı
        }
    }
}

function writecomment()
// başlığı beğen
{
    global $comment_code; // comment_code değişkenini her yerde kullanabiliriz.
    global $uyeler_kadi; // üye kullanıcı adı
    global $securitycode; // güvenlik kodu
    
    include("ayar.php"); // ayar dosyası
    
    $p = @$_GET["p"]; // sayfa adı
    
    $comment_code = Code(); // likekımızı güvenlik içine aldığımız değişken
    $commentator  = $uyeler_kadi; // yorumun sahibi, bu yorumu kim yapmış?
    
    if (isset($_POST["comm"])) { // Eğer like tuşuna basılmışsa
        $kod     = $_POST["kod"]; // Güvenlik kodu değişkeni
        $comment = $_POST["comment"]; // Güvenlik kodu değişkeni
        
        if (empty($comment)) { // Eğer $comment boş ise
            echo 'Please do not leave it blank! :S';
        } else { // Eğer $comment boş değil ise
            if ($kod = $securitycode) { // Eğer kod değişkenin içinde ki veri ile securitycode değişkenin içindeki veri eşitse
                $insert = $db->prepare("INSERT INTO yorumlar SET yorumlar_yorum=?, yorumlar_sahip=?, yorumlar_link=?");
                $insert->execute(array(
                    $comment,
                    $commentator,
                    $p
                ));
                
                if ($insert) { // Yükleme işlemi başarılı ise
                    echo '<br />You commented successfully. :)<br />';
                } else { // Yükleme işlemi başarısız ise
                    echo '<br />Oh, theres something wrong! :(<br />'; // Hata mesajı
                }
            } else { // Eğer veriler eşit değilse
                echo 'Oh, theres something wrong! :(<br />'; // Hata mesajı
            }
        }
    }
}

function comment()
// yorumlar
{
    global $p; // global p
    global $uyeler_kadi; // global kadi
    
    include("ayar.php"); // ayar dosyası
    $num_rec_per_page = 10; // Ekranda kaç yorum gözüksün?
    
    try {
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }
        ;
        
        $start_from = ($page - 1) * $num_rec_per_page;
        $sql        = "SELECT * FROM yorumlar WHERE yorumlar_link=? ORDER BY yorumlar_id DESC LIMIT $start_from, $num_rec_per_page";
        $rs_result  = $db->prepare($sql);
        $rs_result->setFetchMode(PDO::FETCH_ASSOC);
        $rs_result->execute(array(
            $p
        ));
        
        if ($rs_result->rowCount() > 0) {
            
            echo '<ul>';
            while ($row = $rs_result->fetchObject()) { // Yorum listesi burada olacak
                echo '
                <li class="share">
                    ' . $row->yorumlar_yorum . '<br />
                    <small><a href="profile?u=' . $row->yorumlar_sahip . '">' . $row->yorumlar_sahip . '</a> - <em>' . $row->yorumlar_tarih . '</em></small>
                </li>
                ';
            }
            echo '</ul>';
        } else {
            echo "Not commented. (:<br />"; // Hata Mesajı
        }
    }
    catch (PDOException $pe) {
        echo "<br />Oh, theres something wrong! :(<br />"; // Hata Mesajı
    }
    
    $sql       = "SELECT * FROM yorumlar WHERE yorumlar_link=?";
    $rs_result = $db->prepare($sql);
    $rs_result->execute(array(
        $p
    ));
    $total_records = $rs_result->rowCount();
    $total_pages   = ceil($total_records / $num_rec_per_page);
    
    echo '<br /><a href="?p=' . $p . '&page=1" class="m2">First</a> '; // İlk Sayfa
    
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '<a href="page?p=' . $p . '&page=' . $i . '" class="m2">' . $i . '</a> ';
    }
    ;
    
    echo ' <a href="page?p=' . $p . '&page=' . $total_pages . '" class="m2">Next</a>'; // Sonraki Sayfa
}

function hot()
// Dumanı üstünde, fırından yeni çıkanlar, sıcak, yeniler işte aga
{
    global $p;
    
    include("ayar.php"); // ayar dosyası
    $num_rec_per_page = 10; // Ekranda kaç yorum gözüksün?
    
    try {
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }
        ;
        
        $start_from = ($page - 1) * $num_rec_per_page;
        $sql        = "SELECT * FROM basliklar ORDER BY baslik_id DESC LIMIT $start_from, $num_rec_per_page";
        $rs_result  = $db->prepare($sql);
        $rs_result->setFetchMode(PDO::FETCH_ASSOC);
        $rs_result->execute();
        
        if ($rs_result->rowCount() > 0) {
            echo '<ul>';
            while ($row = $rs_result->fetchObject()) { // Yorum listesi burada olacak
                echo '
                <li class="share">
                    <span>' . $row->baslik_begen . ' Like</span> <a href="page?p=' . $row->baslik_baslik_replace . '">' . $row->baslik_baslik . '</a><br />
                    <small><a href="profile?u=' . $row->baslik_sahip . '">' . $row->baslik_sahip . '</a> - <em>' . $row->baslik_tarih . '</em></small>
                </li>
                ';
            }
            echo '</ul>';
        } else {
            echo "Not commented. (:<br />"; // Hata Mesajı
        }
    }
    catch (PDOException $pe) {
        echo "<br />Oh, theres something wrong! :(<br />"; // Hata Mesajı
    }
    
    $sql       = "SELECT * FROM basliklar";
    $rs_result = $db->prepare($sql);
    $rs_result->execute();
    $total_records = $rs_result->rowCount();
    $total_pages   = ceil($total_records / $num_rec_per_page);
    
    echo '<br /><a href="home?p=hot&page=1" class="m2">First</a>'; // İlk Sayfa
    
    for ($i = 1; $i <= $total_pages; $i++) {
        echo ' <a href="home?p=hot&page=' . $i . '" class="m2">' . $i . '</a> ';
    }
    ;
    
    echo '<a href="home?p=hot&page=' . $total_pages . '" class="m2">Next</a>'; // Sonraki Sayfa
}

function week()
// son 7 gün yani son 1 hafta ikisi de aynı şey işte la :D
{
    global $p;
    
    include("ayar.php"); // ayar dosyası
    $num_rec_per_page = 10; // Ekranda kaç yorum gözüksün?
    
    try {
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }
        ;
        
        $start_from = ($page - 1) * $num_rec_per_page;
        $sql        = "SELECT * FROM basliklar WHERE WEEK(baslik_tarih) = WEEK(CURDATE()) ORDER BY baslik_begen DESC LIMIT $start_from, $num_rec_per_page";
        $rs_result  = $db->prepare($sql);
        $rs_result->setFetchMode(PDO::FETCH_ASSOC);
        $rs_result->execute();
        
        if ($rs_result->rowCount() > 0) {
            echo '<ul>';
            while ($row = $rs_result->fetchObject()) { // Yorum listesi burada olacak
                echo '
                <li class="share">
                    <span>' . $row->baslik_begen . ' Like</span> <a href="page?p=' . $row->baslik_baslik_replace . '">' . $row->baslik_baslik . '</a><br />
                    <small><a href="profile?u=' . $row->baslik_sahip . '">' . $row->baslik_sahip . '</a> - <em>' . $row->baslik_tarih . '</em></small>
                </li>
                ';
            }
            echo '</ul>';
        } else {
            echo "Not commented. (:<br />"; // Hata Mesajı
        }
    }
    catch (PDOException $pe) {
        echo "<br />Oh, theres something wrong! :(<br />"; // Hata Mesajı
    }
    
    $sql       = "SELECT * FROM basliklar";
    $rs_result = $db->prepare($sql);
    $rs_result->execute();
    $total_records = $rs_result->rowCount();
    $total_pages   = ceil($total_records / $num_rec_per_page);
    
    echo '<br /><a href="home?p=hot&page=1" class="m2">First</a>'; // İlk Sayfa
    
    for ($i = 1; $i <= $total_pages; $i++) {
        echo ' <a href="home?p=hot&page=' . $i . '" class="m2">' . $i . '</a> ';
    }
    ;
    
    echo '<a href="home?p=hot&page=' . $total_pages . '" class="m2">Next</a>'; // Sonraki Sayfa
}

function month()
// son 30 gün yani son 1 ay ikisi de aynı şey işte la (:)
{
    global $p;
    
    include("ayar.php"); // ayar dosyası
    $num_rec_per_page = 10; // Ekranda kaç yorum gözüksün?
    
    try {
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }
        ;
        
        $start_from = ($page - 1) * $num_rec_per_page;
        $sql        = "SELECT * FROM basliklar WHERE MONTH(baslik_tarih) = MONTH(CURDATE()) ORDER BY baslik_begen DESC LIMIT $start_from, $num_rec_per_page";
        $rs_result  = $db->prepare($sql);
        $rs_result->setFetchMode(PDO::FETCH_ASSOC);
        $rs_result->execute();
        
        if ($rs_result->rowCount() > 0) {
            echo '<ul>';
            while ($row = $rs_result->fetchObject()) { // Yorum listesi burada olacak
                echo '
                <li class="share">
                    <span>' . $row->baslik_begen . ' Like</span> <a href="page?p=' . $row->baslik_baslik_replace . '">' . $row->baslik_baslik . '</a><br />
                    <small><a href="profile?u=' . $row->baslik_sahip . '">' . $row->baslik_sahip . '</a> - <em>' . $row->baslik_tarih . '</em></small>
                </li>
                ';
            }
            echo '</ul>';
        } else {
            echo "Not commented. (:<br />"; // Hata Mesajı
        }
    }
    catch (PDOException $pe) {
        echo "<br />Oh, theres something wrong! :(<br />"; // Hata Mesajı
    }
    
    $sql       = "SELECT * FROM basliklar";
    $rs_result = $db->prepare($sql);
    $rs_result->execute();
    $total_records = $rs_result->rowCount();
    $total_pages   = ceil($total_records / $num_rec_per_page);
    
    echo '<br /><a href="home?p=hot&page=1" class="m2">First</a>'; // İlk Sayfa
    
    for ($i = 1; $i <= $total_pages; $i++) {
        echo ' <a href="home?p=hot&page=' . $i . '" class="m2">' . $i . '</a> ';
    }
    ;
    
    echo '<a href="home?p=hot&page=' . $total_pages . '" class="m2">Next</a>'; // Sonraki Sayfa
}

function home_today()
// bugünün en iyi 5 başlığı
{
    global $p;
    
    include("ayar.php"); // ayar dosyası
    $num_rec_per_page = 5; // Ekranda kaç yorum gözüksün?
    
    try {
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }
        ;
        
        $start_from = ($page - 1) * $num_rec_per_page;
        $sql        = "SELECT * FROM basliklar WHERE DAY(baslik_tarih) = DAY(CURDATE()) ORDER BY baslik_begen DESC LIMIT $start_from, $num_rec_per_page";
        $rs_result  = $db->prepare($sql);
        $rs_result->setFetchMode(PDO::FETCH_ASSOC);
        $rs_result->execute();
        
        if ($rs_result->rowCount() > 0) {
            echo '<ul>';
            while ($row = $rs_result->fetchObject()) { // Yorum listesi burada olacak
                echo '
                <li class="share">
                    <span>' . $row->baslik_begen . ' Like</span> <a href="page?p=' . $row->baslik_baslik_replace . '">' . $row->baslik_baslik . '</a><br />
                    <small><a href="profile?u=' . $row->baslik_sahip . '">' . $row->baslik_sahip . '</a> - <em>' . $row->baslik_tarih . '</em></small>
                </li>
                ';
            }
            echo '</ul>';
        } else {
            echo ":(<br />"; // Hata Mesajı
        }
    }
    catch (PDOException $pe) {
        echo "<br />Oh, theres something wrong! :(<br />"; // Hata Mesajı
    }
}

function home_week()
// haftanın en iyi 5 başlığı
{
    global $p;
    
    include("ayar.php"); // ayar dosyası
    $num_rec_per_page = 5; // Ekranda kaç yorum gözüksün?
    
    try {
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }
        ;
        
        $start_from = ($page - 1) * $num_rec_per_page;
        $sql        = "SELECT * FROM basliklar  WHERE WEEK(baslik_tarih) = WEEK(CURDATE()) ORDER BY baslik_begen DESC LIMIT $start_from, $num_rec_per_page";
        $rs_result  = $db->prepare($sql);
        $rs_result->setFetchMode(PDO::FETCH_ASSOC);
        $rs_result->execute();
        
        if ($rs_result->rowCount() > 0) {
            echo '<ul>';
            while ($row = $rs_result->fetchObject()) { // Yorum listesi burada olacak
                echo '
                <li class="share">
                    <span>' . $row->baslik_begen . ' Like</span> <a href="page?p=' . $row->baslik_baslik_replace . '">' . $row->baslik_baslik . '</a><br />
                    <small><a href="profile?u=' . $row->baslik_sahip . '">' . $row->baslik_sahip . '</a> - <em>' . $row->baslik_tarih . '</em></small>
                </li>
                ';
            }
            echo '</ul>';
        } else {
            echo ":(<br />"; // Hata Mesajı
        }
    }
    catch (PDOException $pe) {
        echo "<br />Oh, theres something wrong! :(<br />"; // Hata Mesajı
    }
}

function home_month()
// ayın en iyi 5 başlığı
{
    global $p;
    
    include("ayar.php"); // ayar dosyası
    $num_rec_per_page = 5; // Ekranda kaç yorum gözüksün?
    
    try {
        if (isset($_GET["page"])) {
            $page = $_GET["page"];
        } else {
            $page = 1;
        }
        ;
        
        $start_from = ($page - 1) * $num_rec_per_page;
        $sql        = "SELECT * FROM basliklar WHERE MONTH(baslik_tarih) = MONTH(CURDATE()) ORDER BY baslik_begen DESC LIMIT $start_from, $num_rec_per_page";
        $rs_result  = $db->prepare($sql);
        $rs_result->setFetchMode(PDO::FETCH_ASSOC);
        $rs_result->execute();
        
        if ($rs_result->rowCount() > 0) {
            echo '<ul>';
            while ($row = $rs_result->fetchObject()) { // Yorum listesi burada olacak
                echo '
                <li class="share">
                    <span>' . $row->baslik_begen . ' Like</span> <a href="page?p=' . $row->baslik_baslik_replace . '">' . $row->baslik_baslik . '</a><br />
                    <small><a href="profile?u=' . $row->baslik_sahip . '">' . $row->baslik_sahip . '</a> - <em>' . $row->baslik_tarih . '</em></small>
                </li>
                ';
            }
            echo '</ul>';
        } else {
            echo ":(<br />"; // Hata Mesajı
        }
    }
    catch (PDOException $pe) {
        echo "<br />Oh, theres something wrong! :(<br />"; // Hata Mesajı
    }
}

$dosya = file_get_contents('footer.php'); 
if( !preg_match('#<p class="text-center">A product by <a href="">Uğur KILCI</a>.</p>#' , $dosya) ){ 
	exit("Lütfen footer da değişiklik yapmayın veya kaldırmayın. Linki kaldırmak için ulaşın: ugurbocugu8@gmail.com"); 
}

function replace_tr($text)
// seo link yapısı
{
    $text     = trim($text);
    $search   = array(
        'Ç',
        'ç',
        'Ğ',
        'ğ',
        'ı',
        'İ',
        'Ö',
        'ö',
        'Ş',
        'ş',
        'Ü',
        'ü',
        ' '
    );
    $replace  = array(
        'c',
        'c',
        'g',
        'g',
        'i',
        'i',
        'o',
        'o',
        's',
        's',
        'u',
        'u',
        '-'
    );
    $new_text = str_replace($search, $replace, $text);
    return strtolower($new_text);
}

function add()
// başlık ekle
{
    include("ayar.php"); // config
    global $uyeler_kadi;
    global $securitycode;
    
    if (isset($_POST["addtitle"])) {
        $title   = htmlspecialchars(strip_tags($_POST["title"])); // başlık
        $content = htmlspecialchars(strip_tags($_POST["content"])); // açıklama
        $replace = replace_tr($title) . "-" . Code();
        $sahip   = $uyeler_kadi; // başlık sahibi
        $tarih   = date("Y-m-d h:i:s"); // açıklama
        $kod     = $_POST["kod"]; // kod
        
        if (empty($title) || empty($content) || empty($sahip) || empty($tarih)) {
            echo "Please do not leave it blank! :ı<br />";
        } else {
            if ($kod = $securitycode) {
                $baslikac = $db->prepare("INSERT INTO basliklar set baslik_baslik=?, baslik_baslik_replace=?, baslik_aciklama=?, baslik_sahip=?, baslik_tarih=?");
                $baslikac->execute(array(
                    $title,
                    $replace,
                    $content,
                    $sahip,
                    $tarih
                ));
                
                if ($baslikac) { // başarıyla eklendi
                    echo "Success :)<br />";
                } else { // hata var!
                    echo "Error :(<br />";
                }
            } else { // Eğer bir farklılık varsa
                echo 'Your security code is in error and cannot be processed! :S'; // hata mesajı
            }
        }
    }
}
?>