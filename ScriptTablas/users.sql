-- phpMyAdmin SQL Dump
-- version 4.2.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 10, 2015 at 05:01 PM
-- Server version: 5.5.41-0ubuntu0.14.10.1
-- PHP Version: 5.5.12-2ubuntu4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `laravel`
--

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `tienda_id`, `username`, `nombre`, `apellido`, `email`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'usuario1', 'Hector', 'Espana', 'email1@gmail.com', '$2y$10$yWFTsL3a10.MYf48XgOcxeAtbZ9Wu2kMyClDU6VsSO0/VK2a3HgdW', 1, NULL, '2015-02-16 17:23:13', '2015-02-16 17:23:13'),
(2, 1, 'usuario2', 'Salvador', 'Hernandez', 'email2@gmail.com', '$2y$10$WMqm5pck1AA.b6BfnpIeOuzb1k1ZVtVM2vgRpiWDzU.TJ0O2SJ7qC', 1, NULL, '2015-02-16 17:23:13', '2015-02-16 17:23:13'),
(3, 1, 'usuario3', 'Sergio', 'Choto', 'email3@gmail.com', '$2y$10$mkT/8jv/ZvMWTtSCoAusj.YIgt4R6hIA42PMAiaA8XfpEhPcXPPgK', 1, NULL, '2015-02-16 17:23:13', '2015-02-16 17:23:13'),
(4, 1, 'usuario4', 'Keren', 'Sandoval', 'email4@gmail.com', '$2y$10$Uif2Mjk.HyCR3ESraTMEQ.SWqn5CoY/hUU2PGd4Xz2jDOhjQ5IN9O', 1, NULL, '2015-02-16 17:23:13', '2015-02-16 17:23:13'),
(5, 1, 'usuario5', 'Kelly', 'Rosa', 'email5@gmail.com', '$2y$10$OqV.lLHM7XSCqy3eSWEvVukRB8EzQZMwBtaik3Pin.0.Pfpo7ZGZu', 1, NULL, '2015-02-16 17:23:13', '2015-02-16 17:23:13'),
(6, 1, 'usuario6', 'Gilder', 'Hernandez', 'email6@gmail.com', '$2y$10$QpTpFjV0QZEd6KQZydVaXevInpe5sjpKYjGWVeYSIJA2P6uNVvesC', 1, NULL, '2015-02-16 17:23:14', '2015-02-16 17:23:14'),
(7, 1, 'usuario7', 'Edvin', 'Rizo', 'email7@gmail.com', '$2y$10$Cu1pHv7BNh9.FOy6pvbpiOWMzU9Qqrs45shY5Y5O/kETv.4qaBO9W', 1, NULL, '2015-02-16 17:23:14', '2015-02-16 17:23:14'),
(8, 1, 'usuario8', 'Jorge', 'Luis', 'email8@gmail.com', '$2y$10$rkI5IoddiFOCt41Dbk35ueOjFEi.7JDAUH2.pTu4z2NZ5y9XHQIjy', 1, NULL, '2015-02-16 17:23:14', '2015-02-16 17:23:14'),
(9, 1, 'usuario9', 'Samuel', 'Chacon', 'email9@gmail.com', '$2y$10$YOw82HbDY/U01l2aZVoqzOIUiZqJgl7Dl4rJAoAWuiR3UfLEUpUgy', 1, NULL, '2015-02-16 17:23:14', '2015-02-16 17:23:14'),
(10, 1, 'usuario10', 'Anlly', 'EspaÃ±a', 'email10@gmail.com', '$2y$10$IDA0qY6H2d7Qt9KcNOOSRu5sbVrRLQLIYZSAIJWiPgxRwJChJbiq6', 1, NULL, '2015-02-16 17:23:14', '2015-02-16 17:23:14'),
(11, 1, 'usuario11', 'Evelyn', 'Cardona', 'email11@gmail.com', '$2y$10$Z1m3xyuViUJdYcJQoElzCO8irXUinFm5KhtIvpxWcHEHAB9I7R5VG', 2, NULL, '2015-02-16 17:23:14', '2015-02-16 17:23:14'),
(12, 1, 'usuario12', 'Gerber', 'Estrada', 'email12@gmail.com', '$2y$10$oNSTSAWpwu88Bg3xbHewFuDFOXtSArt4aolihF7Om51J0PWR/eX0K', 2, NULL, '2015-02-16 17:23:14', '2015-02-16 17:23:14'),
(13, 1, 'usuario13', 'Kelly', 'Rosa', 'email13@gmail.com', '$2y$10$YjTZR0/NTyTb/XvQHfVR0OKcU5HT1zeSTXGys31e/DX3H9CbMSYTu', 1, NULL, '2015-02-16 17:23:14', '2015-02-16 17:23:14'),
(14, 1, 'usuario14', 'Keren', 'Sandoval', 'email14@gmail.com', '$2y$10$wJyYxD1KeeNVIUkruT3EyeW3ApGU.60DSGnBHlE7YrNL9idJOHkwC', 1, NULL, '2015-02-16 17:23:14', '2015-02-16 17:23:14'),
(15, 1, 'usuario15', 'Carlos', 'Vacaro', 'email15@gmail.com', '$2y$10$qlN5sfaK9blkki64WW4Cx.Nqz3.OhSSWkAIMauaREL3NM94pGwSUu', 1, NULL, '2015-02-16 17:23:14', '2015-02-16 17:23:14'),
(16, 1, 'usuario16', 'Evelin', 'Cardona', 'email16@gmail.com', '$2y$10$Nw9psXTcIsKqyXNdFh7ysO7p/j47NNQ7QvERGZ/ZjNJDm1JzGlpL2', 1, NULL, '2015-02-16 17:23:14', '2015-02-16 17:23:14'),
(17, 1, 'usuario17', 'Angel', 'Gutierrez', 'email17@gmail.com', '$2y$10$vSsxBlC8bab/w8XY5Wqe.euZAb.WALVuSMLbcuQb/UcurahNmavZq', 1, NULL, '2015-02-16 17:23:15', '2015-02-16 17:23:15'),
(18, 1, 'usuario18', 'Carlos', 'Vacaro', 'email18@gmail.com', '$2y$10$T4B.9fowzzt9KXoX50Bm/.OSI0UMUi0gPnHGXHnmGmei5Qw/v3Rry', 2, NULL, '2015-02-16 17:23:15', '2015-02-16 17:23:15'),
(19, 1, 'usuario19', 'Jorge', 'Luis', 'email19@gmail.com', '$2y$10$Bpqkntlr5gYqDMss658vMek2/OoI5nLgm8BBk2qYkvCqyxv4vS0n.', 1, NULL, '2015-02-16 17:23:15', '2015-02-16 17:23:15'),
(20, 1, 'usuario20', 'Angel', 'Gutierrez', 'email20@gmail.com', '$2y$10$9tv/XxZHtftSoOlymWMap.b.8jcaftFzrxRjbYYj38yfdnJfQwkq2', 1, NULL, '2015-02-16 17:23:15', '2015-02-16 17:23:15'),
(21, 1, 'usuario21', 'Mario', 'Calderon', 'email21@gmail.com', '$2y$10$uAaa.g7vFPWCF//VDoYt6OKGwelZjU4viw8Dk/JjXCc4HaFHhsWY.', 1, NULL, '2015-02-16 17:23:15', '2015-02-16 17:23:15'),
(22, 1, 'usuario22', 'Mario', 'Calderon', 'email22@gmail.com', '$2y$10$1ozriSXFH0et3gwMNF4M.elwVkPkMzqAfyep7Ia1l.kEA7V9wGwna', 1, NULL, '2015-02-16 17:23:15', '2015-02-16 17:23:15'),
(23, 1, 'usuario23', 'Hector', 'Salazar', 'email23@gmail.com', '$2y$10$r/3jjnWCFLVrfU37nmW99uz71mRvmhD3DLwIRxhRUI120MGJSeqMu', 2, NULL, '2015-02-16 17:23:15', '2015-02-16 17:23:15'),
(24, 1, 'usuario24', 'Fabiola', 'Castillo', 'email24@gmail.com', '$2y$10$P63vDq5X7QRj5ugWJ77OuuShQWTqqeTN/ZWG2Y4UhlhC.zW.xxY9C', 2, NULL, '2015-02-16 17:23:15', '2015-02-16 17:23:15'),
(25, 1, 'usuario25', 'David', 'Tejeda', 'email25@gmail.com', '$2y$10$WCHPEb5zCYyLDLn2lbc78.u26ewh.I8n.svh6TuaxRx2WdA8WDyd.', 1, NULL, '2015-02-16 17:23:15', '2015-02-16 17:23:15'),
(26, 1, 'usuario26', 'Antonio', 'Lopez', 'email26@gmail.com', '$2y$10$nY214vCodeUVp.Mg3BXJduLuPmC6jdWagLHLOY3dbjIk1JxYlAMwW', 2, NULL, '2015-02-16 17:23:15', '2015-02-16 17:23:15'),
(27, 1, 'usuario27', 'Usuario', 'Tienda', 'email27@gmail.com', '$2y$10$RG/RiXDElLAzhVEQSAWiKunYGhonn5liBCOvttwkz6TaBoBsPTlj.', 1, NULL, '2015-02-16 17:23:15', '2015-02-16 17:23:15'),
(28, 1, 'usuario28', 'Hector', 'España', 'email28@gmail.com', '$2y$10$Uy4Xvadm94WqcpS53tsyBONIZe2IoUYuYXd3HD/NW0VDNR3hdfx.u', 1, NULL, '2015-02-16 17:23:16', '2015-02-16 17:23:16'),
(29, 1, 'usuario29', 'Fabiola', 'Veliz', 'email29@gmail.com', '$2y$10$h1J0PXoS26GxnHUtnB.Ztepq4SW.JmNfNTBTR4oUp79kO7MG1MMom', 1, NULL, '2015-02-16 17:23:16', '2015-02-16 17:23:16'),
(30, 1, 'usuario30', 'David', 'Tejada', 'email30@gmail.com', '$2y$10$DTwoeosM3.ag5jVAExVGfeZn6MPtIQpsI4Us7HFf4/h0P8fsAYUJK', 1, NULL, '2015-02-16 17:23:16', '2015-02-16 17:23:16'),
(32, 2, 'usuario31', 'Usuario', 'Bodega', 'email31@gmail.com', '$2y$10$zcXd27MJMt6eM.5xyUhk9uvLLb28Uhu1OJl.KTe3.Q1D7SvaKSltK', 1, NULL, '2015-02-16 17:23:16', '2015-02-16 17:23:16'),
(33, 1, 'usuario32', 'Josue', 'Orellana', 'email32@gmail.com', '$2y$10$oSy6XZb8vz3GkFirXB8oXukbBDKFSvjsHtSvuX2V4zjhJvfQKNz.C', 1, NULL, '2015-02-16 17:23:16', '2015-02-16 17:23:16'),
(35, 1, 'usuario33', 'Leonel', 'Madrid Franco', 'email33@gmail.com', '$2y$10$0uUkk3rUR2fiJh5CI/NHouasgkBE9FtSmXVPsIatO1eDwxA7xf2di', 1, NULL, '2015-02-16 17:23:16', '2015-02-16 17:23:16'),
(36, 1, 'hsosan1', 'Gilder', 'Hernandez', 'hsosan1@hotmail.com', '$2y$10$a3RYm/KcLI8CQGGJzEDBvutTRUr.pZ8mJzvSf/pSNSlQ.d6KBmSJy', 1, 'fa9WFb5heHN6ruvzOaVq3jXALaAK9rTu8W0Y1hJG57pclH2KazQTkLR8K40o', '2015-02-16 17:25:16', '2015-02-16 17:25:34'),
(37, 1, 'admin', 'admin', 'admin', 'admin@hotmail.com', '$2y$10$xwytKMntKTwh.ZcPO.0RxuhOLwFvxZZGPllTXoiMnxVlW7uahALPG', 1, 'XS1P5ST7mVuJVQSYWetXSm35WmTwaz3Smjk5VE9iBy1m62jmCoJJb2lwfFyb', '2015-02-16 17:25:16', '2015-03-10 19:09:44'),
(38, 1, 'usuario', 'usuario', 'usuario', 'usuario@hotmail.com', '$2y$10$UiURFOMfD7cZ0zH5TJ551.wMaHxShVObBkK2N5EJDj1PE5/x.3bl2', 1, NULL, '2015-02-16 17:25:17', '2015-02-16 17:25:17'),
(39, 1, 'Nelug', 'Leonel', 'Alberto', 'Leonel@hotmail.com', '$2y$10$2C4j9NX3OBI0nG1.ntbJI.ftz8S8WhpgXg1GcqhBwbCBtyWw8TV92', 1, NULL, '2015-03-10 19:11:03', '2015-03-10 19:11:03');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
