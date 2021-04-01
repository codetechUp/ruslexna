<?php 
namespace App\apiPayndunya;
use Paydunya\Setup;
use Paydunya\Paydunya;
use Paydunya\Checkout\Store;

//Configuration des informations de votre service/entreprise
Setup::setMasterKey("sO4bJTB1-VGno-uwPH-HRMT-6C5H4kNFu8Qn");
Setup::setPublicKey("test_public_tzTd3klc9WYzradGceuoHmaPvKR");
Setup::setPrivateKey("test_private_NHEmeiZn3nUAyq0sYprqRhJlYxH");
Setup::setToken("FWqNtl4ydmUdpsCcSlKa");
Setup::setMode("test"); // Optionnel. Utilisez cette option pour les paiements tests.
Store::setLogoUrl("http://nasrulex.com/senjuridoc.jpg");

Store::setName("NASRULEX"); // Seul le nom est requis
Store::setTagline("plateforme de documenation juridique");
Store::setPhoneNumber("+221 77 377 77 66");
Store::setWebsiteUrl("http://nasrulex.com");

//Store::setReturnUrl("http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME'])."/confirm.php");
/**
 * Setup::setMasterKey("sO4bJTB1-VGno-uwPH-HRMT-6C5H4kNFu8Qn");
*Setup::setPublicKey("live_public_eGHyRPJlnkWZpCRWoeaqorkgTcM");
*Setup::setPrivateKey("live_private_542NI1K1OydZQRPB1mE2uWFgraY");
*Setup::setToken("9tIQowOQQxlNEhQaVIzl");
*Setup::setMode("live");
 */