-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 17 Jun 2026 pada 17.33
-- Versi server: 10.6.25-MariaDB-cll-lve
-- Versi PHP: 8.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `localmar_toeflin`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `audios`
--

CREATE TABLE `audios` (
  `id` varchar(36) NOT NULL,
  `fileUrl` varchar(255) NOT NULL,
  `transcript` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `passages`
--

CREATE TABLE `passages` (
  `id` varchar(36) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `questions`
--

CREATE TABLE `questions` (
  `id` varchar(36) NOT NULL,
  `section` varchar(255) NOT NULL,
  `skillCategory` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `choices` text NOT NULL,
  `answerKey` varchar(255) NOT NULL,
  `explanation` text DEFAULT NULL,
  `audioId` varchar(255) DEFAULT NULL,
  `passageId` varchar(255) DEFAULT NULL,
  `packageId` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `questions`
--

INSERT INTO `questions` (`id`, `section`, `skillCategory`, `content`, `choices`, `answerKey`, `explanation`, `audioId`, `passageId`, `packageId`) VALUES
('0232e62f-6b00-48fd-9a44-360fb8d2c697', 'Reading', NULL, '15.	According to the passage, palms live in these countries EXCEPT', '{\"a\":\"a.\\tMexico \",\"b\":\"b.\\tSouth Africa \",\"c\":\"c.\\tFlorida \",\"d\":\"d.\\tArctic\"}', 'a', '', NULL, NULL, NULL),
('0bc00624-83d2-47e6-b361-9c16f589bfa4', 'Reading', NULL, '28.	The word “grouped” in line 18 is closest in meaning to', '{\"a\":\"a.\\tClassified\",\"b\":\"b.\\tformed \",\"c\":\"c.\\tlisted \",\"d\":\"d.\\tranked\"}', 'a', '', NULL, NULL, NULL),
('0e3cf4ec-a107-4a08-ad3c-7bd3376996f0', 'Structure', NULL, '14.	Carbohydrates, _   Of the  three principal constituents of food, form the bulk of the average human diet.', '{\"a\":\"(A)\\tare one \",\"b\":\" (B)\\tone that \",\"c\":\"(C)\\tone\",\"d\":\"(D)\\twhich one\"}', 'a', '', NULL, NULL, NULL),
('11102dd2-2e25-489a-9d4e-5e3a6678fbf0', 'Structure', NULL, '8.	When played in certain ways, the bassoon can produce comical sounds, ____it is sometimes referred to as the clown of the orchestra.', '{\"a\":\"(A)\\tor \",\"b\":\"(B)\\tthat\",\"c\":\"(C)\\tso \",\"d\":\"(D)\\twhether\"}', 'a', '', NULL, NULL, NULL),
('132127ca-021a-4fb9-a52c-2c1cbbf602e5', 'Structure', NULL, '9.	The 1903 film The Great Train Robbery was the first significant film in which the classic western story’s formula of crime and retribution______', '{\"a\":\"(A). was used \",\"b\":\"(B). to be used\",\"c\":\"(C). used\",\"d\":\"(D). had use\"}', 'a', '', NULL, NULL, NULL),
('15b41268-acc8-4cea-bca5-32455bff9c8a', 'Reading', NULL, '12.	The word ‘currently’ in line 4 is  closest in meaning to', '{\"a\":\"a.\\tnew \",\"b\":\"b.\\tnow \",\"c\":\"c.\\tpresent \",\"d\":\"d.\\tthen\"}', 'a', '', NULL, NULL, NULL),
('16e3a242-0c90-464a-8dba-ad84d0e59af1', 'Reading', NULL, '35.	The word ‘major’ in line 16 is closest in meaning to', '{\"a\":\"a.\\tbasic \",\"b\":\"b.\\tbig \",\"c\":\"c.\\tbase\",\"d\":\"d.\\tmany\"}', 'a', '', NULL, NULL, NULL),
('18eafe08-e6bd-4cfc-9730-9bdad1d6353b', 'Reading', NULL, '50. According to the passage, what does a constricted and harsh voice indicate? ', '{\"a\":\"a.\\tLethargy  \",\"b\":\"b.\\tDepression \",\"c\":\"c.\\tBoredom \",\"d\":\"d.\\tAnger\"}', 'a', '', NULL, NULL, NULL),
('1a4ae445-f947-41c0-9877-dd28cee9177e', 'Reading', NULL, '43. The word “Here” in line 10 refers to ', '{\"a\":\"a.\\tinterpersonal interactions  \",\"b\":\"b.\\tthe tone  \",\"c\":\"c.\\tideas and feelings  \",\"d\":\"d.\\twords chosen\"}', 'a', '', NULL, NULL, NULL),
('1b3e9224-9977-48ec-8ac9-0046e3c87678', 'Structure', NULL, '1. The gray scale, a progressive series of shades ranging from black to white, is used in computer graphics _____detail to graphical images.', '{\"a\":\"(A) added\",\"b\":\"(B) to add\",\"c\":\"(C) are added (D) and add\",\"d\":\"(D) and add\"}', 'a', '', NULL, NULL, NULL),
('201889e2-7767-4ef0-a263-a3d96cc602ba', 'Reading', NULL, '41. What does the passage mainly discuss?', '{\"a\":\"a.\\tThe function of the voice in performance  \",\"b\":\"b.\\tThe connection between voice and personality\",\"c\":\"c.\\tCommunication styles \",\"d\":\"d.\\tThe production of speech\"}', 'a', '', NULL, NULL, NULL),
('267a4c04-39ef-45e9-b34b-ccc968f48d2c', 'Structure', NULL, '4.	The particles in an atom_______a neutral charge are called neutrons.', '{\"a\":\"(A)\\thaving \",\"b\":\"(B)\\tis having\",\"c\":\"(C)\\tit is having\",\"d\":\"(D)\\twhich having\"}', 'a', '', NULL, NULL, NULL),
('2893f555-e690-4a94-8f8b-22d8b7eb1444', 'Reading', NULL, '35.	The word ‘major’ in line 16 is closest in meaning to', '{\"a\":\"a.\\tbasic \",\"b\":\"b.\\tbig \",\"c\":\"c.\\tbase\",\"d\":\"d.\\tmany\"}', 'a', '', NULL, NULL, NULL),
('2b950fe7-bc9a-4368-9b13-1db4ff461359', 'Structure', NULL, '2.	 _____ skeleton of an insect is on the outside of its body.  ', '{\"a\":\" (A) Its\",\"b\":\" (B) That the\",\"c\":\"(C) There is a\",\"d\":\" (D) The\"}', 'a', '', NULL, NULL, NULL),
('3079da70-739d-4081-9754-de55dd864cab', 'Reading', NULL, '11.	The best title for this passage  would be', '{\"a\":\"a.\\tPalm trees \",\"b\":\"b.\\tTypes of palm tress \",\"c\":\"c.\\tPalm trees in rainforests anddesserts\",\"d\":\"d.\\tThe importance of palm trees\"}', 'a', '', NULL, NULL, NULL),
('30d2c9d4-ff46-4944-a142-8f90c3a2bae1', 'Structure', NULL, '10.	______of classical ballet in the United States began around 1830.', '{\"a\":\"(A)\\tTo teach\",\"b\":\"(B)\\tIs teaching\",\"c\":\"(C)\\tIt was taught\",\"d\":\"(D)\\tThe teaching\"}', 'a', '', NULL, NULL, NULL),
('3310c22b-e3ad-49be-b56d-5841d1b33587', 'Reading', NULL, '32. According to the passage', '{\"a\":\"a.\\tUN did not replace League Nations \",\"b\":\"b.\\tUN first had more than members 51 members\",\"c\":\"c.\\tOne of UN’s job is to prevent conflicts \",\"d\":\"d.\\tThe UN office is only in New York\"}', 'a', '', NULL, NULL, NULL),
('336cbf36-2b82-4620-9fd3-bb47551b6ca9', 'Reading', NULL, '19.	Which of the following is NOT true about the cultural symbols of palms?', '{\"a\":\"a.\\tThey are symbols for victory \",\"b\":\"b.\\tThey are symbols for peace \",\"c\":\"c.\\tThey are symbols for fertility \",\"d\":\"d.\\tThey are symbols for health\"}', 'a', '', NULL, NULL, NULL),
('374f5845-382d-4fce-a68c-a4d7a5f88429', 'Reading', NULL, '45. Why does the author mention “artistic, political, or pedagogic communication” in line 17? ', '{\"a\":\"a.\\tAs examples of public performance  \",\"b\":\"b.\\tAs examples of basic styles of communication \",\"c\":\"c.\\tTo contrast them to singing\",\"d\":\"d.\\tTo introduce the idea of self-image \"}', 'a', '', NULL, NULL, NULL),
('3e20d850-04b9-416a-b8f8-20177f24a91d', 'Structure', NULL, '15.	J.K. Rowling wrote many amazing  novels	 ___famous worldwide.', '{\"a\":\"(A)\\tthat are became\",\"b\":\" (B)\\tthat became \",\"c\":\"(C)\\twhat became \",\"d\":\"(D)\\twhat had become\"}', 'a', '', NULL, NULL, NULL),
('42062444-481c-4991-a0dc-3d8520fc7b78', 'Reading', NULL, '37.	The word ‘prominent’ in line 30 is closest in meaning to', '{\"a\":\"a.\\tlarge \",\"b\":\"b.\\tfamous\",\"c\":\"c.\\twell \",\"d\":\"d.\\tfond\"}', 'a', '', NULL, NULL, NULL),
('48f00c86-bcce-47cb-86c4-bd456af04ace', 'Reading', NULL, '25.	What is the simple solution which is usually conducted by the people to treat Insomnia?', '{\"a\":\"a.\\tSee the doctor \",\"b\":\"b.\\tDo jogging \",\"c\":\"c.\\tDrink sleeping medicine \",\"d\":\"d.\\tEat much\"}', 'a', '', NULL, NULL, NULL),
('4b468068-2153-49ed-88de-e1279dd1a267', 'Structure', NULL, '13.	Bioethics is	the moral and social implications of techniques resulting from advances in the biological sciences.', '{\"a\":\"(A). study \",\"b\":\"(B). studied \",\"c\":\"(C). the study of \",\"d\":\"(D). the study that\"}', 'a', '', NULL, NULL, NULL),
('587566e8-e103-4365-b168-fd6b30663927', 'Reading', NULL, '26.	The word ‘dependence’ in line 16 has similar meaning with', '{\"a\":\"a.\\tAddiction \",\"b\":\"b.\\tExistence \",\"c\":\"c.\\tAddition \",\"d\":\"d.\\tUsage\"}', 'a', '', NULL, NULL, NULL),
('590a8586-774c-4d1a-90ae-19dac307b5fe', 'Reading', NULL, '30.	  Where in the passage does the author mention about the definition of Insomnia?', '{\"a\":\"a.\\tLine 1 and 2\",\"b\":\"b.\\tLine 6 and 7 \",\"c\":\"c.\\tLine 13 and 14 \",\"d\":\"d.\\tLine 19 and 20\"}', 'a', '', NULL, NULL, NULL),
('5a63a6a1-bbd7-40f3-8c94-03e65fa60f2e', 'Structure', NULL, '7.	Boise became	of the state of Idaho in 1864.', '{\"a\":\"(A)\\tas the capital\",\"b\":\"(B)\\tthe capital\",\"c\":\"(C)\\tto be the capital\",\"d\":\"(D)\\tthe capital was\"}', 'a', '', NULL, NULL, NULL),
('5b008731-36b0-4cda-b774-4fa195e0e693', 'Reading', NULL, '20.	From the passage, it can be inferred that', '{\"a\":\"a.\\tPalms are not useful \",\"b\":\"b.\\tPalms do not live in subtropical areas \",\"c\":\"c.\\tThere are not many kinds of palms \",\"d\":\"d.\\tPalms are cultivated\"}', 'a', '', NULL, NULL, NULL),
('61132bfd-e2f9-42a6-ab12-f12333241074', 'Reading', NULL, '2.	It can be inferred from the passage that', '{\"a\":\"a.\\tthe platypus is not a mammal\",\"b\":\"b.\\tthe platypus does not lay eggs \",\"c\":\"c.\\tthe platypus can be dangerous for human being\",\"d\":\"d.\\tthe platypus in this world\"}', 'a', '', NULL, NULL, NULL),
('629aeadb-af36-4081-ad34-6b5976bcfd5e', 'Reading', NULL, '48. The word “drastically” in line 24 is closest in meaning to ', '{\"a\":\"a.\\tfrequently  \",\"b\":\"b.\\texactly  \",\"c\":\"c.\\tseverely  \",\"d\":\"d.\\teasily \"}', 'a', '', NULL, NULL, NULL),
('69720b1c-7d2e-4fdf-8aa9-8f1b378bf35f', 'Reading', NULL, '36.	Below are the principals organs  that are still active now of UN EXCEPT', '{\"a\":\"a.\\tGeneral Assembly\",\"b\":\"b.\\tSecurity Council \",\"c\":\"c.\\tEconomic and Social Council (ECOSOC) \",\"d\":\"d.\\tUnited Nations Trusteeship Council\"}', 'a', '', NULL, NULL, NULL),
('6a99bf69-cdc7-4ad3-b724-461c777135b7', 'Reading', NULL, '17.	The word ‘they’ in line 24 refers to', '{\"a\":\"a.\\tpalms \",\"b\":\"b.\\tpeace \",\"c\":\"c.\\tvictory \",\"d\":\"d.\\tsymbols\"}', 'a', '', NULL, NULL, NULL),
('6ae137cc-d6b0-40a3-87ba-a5b4e6a5e1e1', 'Reading', NULL, '38.	Where in the passage does the author describe about UN System agencies?', '{\"a\":\"a.\\tLine 20-24 \",\"b\":\"b.\\tLine 24-26 \",\"c\":\"c.\\tLine 28-32 \",\"d\":\"d.\\tLine 33-34\"}', 'a', '', NULL, NULL, NULL),
('78f1a9ee-af95-40b7-b932-b7b7adc7e5a4', 'Reading', NULL, '40.	The paragraph following the passage most likely discusses', '{\"a\":\"a.\\tThe next UN leaders \",\"b\":\"b.\\tThe good status of UN \",\"c\":\"c.\\tThe effectiveness of UN \",\"d\":\"d.\\tThe ineffectiveness of UN\"}', 'a', '', NULL, NULL, NULL),
('7a10db1b-f29f-4c6a-ab9b-34509e7d72f1', 'Reading', NULL, '6.	According to the passage, what is NOT the unusual appearance of the platypus?', '{\"a\":\"a.\\tegg-laying \",\"b\":\"b.\\tduck-billed \",\"c\":\"c.\\tsmall-tailed \",\"d\":\"d.\\totter-footed\"}', 'a', '', NULL, NULL, NULL),
('7b81f9b6-dfe7-46b9-86a5-102877ed4d7a', 'Reading', NULL, '47. According to the passage, an overconfident front may hide ', '{\"a\":\"a.\\thostility \",\"b\":\"b.\\tshyness  \",\"c\":\"c.\\tfriendliness   \",\"d\":\"d.\\tstrength \"}', 'a', '', NULL, NULL, NULL),
('7e80ac9b-02c7-4726-9c5d-a812fb67ed3f', 'Reading', NULL, '27.	It is stated in the passage that Insomnia', '{\"a\":\"a.\\tcan be occurred only to elderly people. \",\"b\":\"b.\\tis waking up problem.\",\"c\":\"c.\\tcan cause memory problem. \",\"d\":\"d.\\tcan be treated by only consum ing sleeping pills\"}', 'a', '', NULL, NULL, NULL),
('7ebf0652-97e4-4b50-972e-cbeecc22ac4e', 'Reading', NULL, '24.	What is NOT the problem caused by Insomnia?', '{\"a\":\"a.\\tDepression \",\"b\":\"b.\\tHeadache \",\"c\":\"c.\\tIrritability \",\"d\":\"d.\\tHeart disease\"}', 'a', '', NULL, NULL, NULL),
('7f19a64e-2d5f-4f91-85db-ff511807c362', 'Structure', NULL, '10.	______of classical ballet in the United States began around 1830.', '{\"a\":\"(A)\\tTo teach\",\"b\":\"(B)\\tIs teaching\",\"c\":\"(C)\\tIt was taught\",\"d\":\"(D)\\tThe teaching\"}', 'a', '', NULL, NULL, NULL),
('7f474fed-3a17-4842-a10f-e9372df1098a', 'Reading', NULL, '31.	The passage is mainly about', '{\"a\":\"a.\\tThe history of UN \",\"b\":\"b.\\tThe story of UN \",\"c\":\"c.\\tThe general description of UN \",\"d\":\"d.\\tThe UN organization principals\"}', 'a', '', NULL, NULL, NULL),
('8a31baa3-cec3-492f-ac79-a1a5b2ed250a', 'Reading', NULL, '18.	The word ‘appearance’ in line 22 is closest in meaning to', '{\"a\":\"a.\\tcharacter \",\"b\":\"b.\\tscene \",\"c\":\"c.\\tlook \",\"d\":\"d.\\tscenery\"}', 'a', '', NULL, NULL, NULL),
('90ec7119-e41e-4269-8efe-9ff0a29169d6', 'Structure', NULL, '12.	In the Arctic tundra, ice fog may form under clear skies in winter, ---- coastal fogs or low status clouds are common in summer.', '{\"a\":\"(A) because of   \",\"b\":\"(B) whereas\",\"c\":\"(C) despite\",\"d\":\"(D) that\"}', 'a', '', NULL, NULL, NULL),
('97779366-1cd7-4ab7-b6c4-05cb859bc8d7', 'Structure', NULL, '10.	______of classical ballet in the United States began around 1830.', '{\"a\":\"(A)\\tTo teach\",\"b\":\"(B)\\tIs teaching\",\"c\":\"(C)\\tIt was taught\",\"d\":\"(D)\\tThe teaching\"}', 'a', '', NULL, NULL, NULL),
('9b3af898-263f-4674-aab5-36a6037c9e26', 'Reading', NULL, '35.	The word ‘major’ in line 16 is closest in meaning to', '{\"a\":\"a.\\tbasic \",\"b\":\"b.\\tbig \",\"c\":\"c.\\tbase\",\"d\":\"d.\\tmany\"}', 'a', '', NULL, NULL, NULL),
('9e6cdacb-cab1-4b98-8129-82d64810aef3', 'Reading', NULL, '44. The word “derived” in line 15 is closest in meaning to ', '{\"a\":\"a.\\tdiscussed  \",\"b\":\"b.\\tprepared   \",\"c\":\"c.\\tregistered  \",\"d\":\"d.\\tobtained \"}', 'a', '', NULL, NULL, NULL),
('a03ca68e-d310-438e-b9d4-719ecdb3eb87', 'Reading', NULL, '22.	The word “demonstrated” in line 3 can be best replaced by', '{\"a\":\"a.\\tShowed \",\"b\":\"b.\\tArgued \",\"c\":\"c.\\tDemoed \",\"d\":\"d.\\tSuggested\"}', 'a', '', NULL, NULL, NULL),
('a21a588e-0346-4494-add4-dde2e4fb2a77', 'Structure', NULL, '5.	By_____excluding competition from an industry, governments have often created public service monopolies.', '{\"a\":\"(A) they adopt laws (B) laws are adopted (C) adopting laws (D) having laws adopt\",\"b\":\"(A) they adopt laws (B) laws are adopted (C) adopting laws (D) having laws adopt\",\"c\":\"(A) they adopt laws (B) laws are adopted (C) adopting laws (D) having laws adopt\",\"d\":\"(A) they adopt laws (B) laws are adopted (C) adopting laws (D) having laws adopt\"}', 'a', '', NULL, NULL, NULL),
('a7944dc3-9a0d-4f54-8307-e20cfb97e460', 'Reading', NULL, '29. Which of the following is NOT true about the passage?', '{\"a\":\"a.\\tSleep disorder is the other name of Insomnia.\",\"b\":\"b.\\tInsomnia can lead people to have physical impairment. \",\"c\":\"c.\\tConsuming sleeping pills doesn’t cause addiction. \",\"d\":\"d.\\tInsomnia can be grouped into two categories.\"}', 'a', '', NULL, NULL, NULL),
('b577aa0f-780f-4d6f-9087-2d1a73f13e38', 'Reading', NULL, '3.	The possessive its in line 4 refers to', '{\"a\":\"a.\\tplatypus\",\"b\":\"b.\\tspecies \",\"c\":\"c.\\tmammal \",\"d\":\"d.\\trepresentative\"}', 'a', '', NULL, NULL, NULL),
('b5847b46-631f-4e59-b86a-b914677e194a', 'Reading', NULL, '7.	The word ‘emblem’ in line 13 is closest in meaning to', '{\"a\":\"a.\\tpicture \",\"b\":\"b.\\tdrawing \",\"c\":\"c.\\tmeaning \",\"d\":\"d.\\tsymbol\"}', 'a', '', NULL, NULL, NULL),
('b8b19362-1b36-4f67-bf3c-6bd98cb2fc3e', 'Reading', NULL, '8.	The passage states that', '{\"a\":\"a.\\tthe female platypus can produce venom \",\"b\":\"b.\\tthe male platypus can produce venom \",\"c\":\"c.\\tall platypus can produce venom \",\"d\":\"d.\\tall platypus are poisonous\"}', 'a', '', NULL, NULL, NULL),
('be4f2762-22d7-4680-8d7c-4606703a7496', 'Reading', NULL, '5.	The word ‘features’ in line 10 is closest in meaning to', '{\"a\":\"a.\\tdescriptions \",\"b\":\"b.\\tcharacteristics\",\"c\":\"c.\\texplanations \",\"d\":\"d.\\tcharacters\"}', 'a', '', NULL, NULL, NULL),
('c1c5657c-ac1a-4393-8614-d12e30859868', 'Reading', NULL, '33.	These are the aims of UN EXCEPT', '{\"a\":\"a.\\tMaintaining international peace and security \",\"b\":\"b.\\tPromoting human rights \",\"c\":\"c.\\tFostering social and economic development \",\"d\":\"d.\\tDestructing the environment\"}', 'a', '', NULL, NULL, NULL),
('c256514e-418f-4d35-994c-af29a49abd4a', 'Reading', NULL, '35.	The word ‘major’ in line 16 is closest in meaning to', '{\"a\":\"a.\\tbasic \",\"b\":\"b.\\tbig \",\"c\":\"c.\\tbase\",\"d\":\"d.\\tmany\"}', 'a', '', NULL, NULL, NULL),
('c5f5c157-4c99-4ae3-9515-e1762d78d29f', 'Reading', NULL, '13.	The expression ‘distinguished by’ in line 6 could be replaced by', '{\"a\":\"a.\\tSeen by \",\"b\":\"b.\\tLost by \",\"c\":\"c.\\tCovered by \",\"d\":\"d.\\tClosed by\"}', 'a', '', NULL, NULL, NULL),
('cdd29cb7-dd23-47d8-bd31-4f3dae5a8bb7', 'Reading', NULL, '49. The word “evidenced” in line 25 is closest in meaning to', '{\"a\":\"a.\\tquestioned  \",\"b\":\"b.\\trepeated  \",\"c\":\" c.\\tindicated \",\"d\":\"d.\\texaggerated \"}', 'a', '', NULL, NULL, NULL),
('d1df65e3-1bf5-4a15-8757-ff66ebf92b52', 'Reading', NULL, '10.	The word ‘immediate’ in line 17 is the closest in meaning to', '{\"a\":\"a.\\tdirect \",\"b\":\"b.\\tsudden \",\"c\":\"c.\\tfast \",\"d\":\"d.\\tquick\"}', 'a', '', NULL, NULL, NULL),
('d20d6aa5-7150-49b9-89f2-2f140568e220', 'Reading', NULL, '21. What is the author’s main point in the passage?', '{\"a\":\"a.\\tAnother name of insomnia \",\"b\":\"b.\\tThe poor quality of sleep \",\"c\":\"c.\\tThe general idea of sleepless- ness \",\"d\":\"d.\\tThe disadvantages of sleep  disorder\"}', 'a', '', NULL, NULL, NULL),
('d4102444-5081-41b4-8cc7-787ede318044', 'Reading', NULL, '23.	Who can get Insomnia?', '{\"a\":\"a.\\tChildren \",\"b\":\"b.\\tElderly people \",\"c\":\"c.\\tTeenager \",\"d\":\"d.\\tAll of the people\"}', 'a', '', NULL, NULL, NULL),
('ded55aac-17c4-43e4-aeeb-bafa8b77c022', 'Structure', NULL, '6.	 Cholesterol is present in large quantities in the nervous system, where ______ compound of myelin.    ', '{\"a\":\"(A)\\tit a\",\"b\":\"(B)\\t a \",\"c\":\"(C)\\tbeing  \",\"d\":\"(D)\\tit is a\"}', 'a', '', NULL, NULL, NULL),
('e1837671-dd68-4ff7-8070-f09af9fe7513', 'Structure', NULL, '3.	Some people_____of money.', '{\"a\":\"(A)\\thave a limited number\",\"b\":\"(B)\\thave a limited amount\",\"c\":\"(C)\\thaving a limited number (D)\\thaving a limited amount\",\"d\":\"(D)\\thaving a limited amount\"}', 'a', '', NULL, NULL, NULL),
('e64c4bcd-2c9e-40ca-aab2-63272f8762d8', 'Reading', NULL, '9.	The passage states that the platypus does not', '{\"a\":\"a.\\tLive in Tasmania \",\"b\":\"b.\\tGive birth \",\"c\":\"c.\\tHave poison \",\"d\":\"d.\\tHave flat tails\"}', 'a', '', NULL, NULL, NULL),
('e864fcba-e6b3-4b7b-a894-cf13e4ab7988', 'Reading', NULL, '34.	The word ‘its’ in line 14 refers to', '{\"a\":\"a.\\tUnited Nations Charter \",\"b\":\"b.\\tConference \",\"c\":\"c.\\tOperation \",\"d\":\"d.\\tUN’s\"}', 'a', '', NULL, NULL, NULL),
('eaee4422-e759-466d-81a2-db387db81755', 'Reading', NULL, '1.	The topic of this passage is', '{\"a\":\"a.\\tthe general information of platypus\",\"b\":\"b.\\tthe features of platypus \",\"c\":\"c.\\tthe unusual appearance of platypus \",\"d\":\"d.\\tthe platypus in this world\"}', 'a', '', NULL, NULL, NULL),
('ec432ff8-5001-431a-87d5-014c5ac676eb', 'Reading', NULL, '4.	It can be inferred from the passage that', '{\"a\":\"a.\\tthe platypus gives birth \",\"b\":\"b.\\tthe platypus is not famous in Australia \",\"c\":\"c.\\tthe platypus is not hunted for its fur today \",\"d\":\"d.\\tthere are still many platy pus living in Australia\"}', 'a', '', NULL, NULL, NULL),
('eecf1883-bded-44a8-a290-0049a56a703c', 'Reading', NULL, '39.	The word ‘granted’ in line 31 can be best replaced by the word', '{\"a\":\"a.\\tbought \",\"b\":\"b.\\tbrought \",\"c\":\"c.\\tgiven \",\"d\":\"d.\\tappeared\"}', 'a', '', NULL, NULL, NULL),
('efa03fd7-3a25-4fcc-977b-70f07420b4e2', 'Reading', NULL, '14.	It can be inferred from the passage t hat', '{\"a\":\"a.\\tMost of the leaves of palms are not green. \",\"b\":\"b.\\tRarely do palms have com- pound leaves. \",\"c\":\"c.\\tMost palm trees can live in tropical areas. \",\"d\":\"d.\\tAll palms live in Cambodia.\"}', 'a', '', NULL, NULL, NULL),
('f36403c4-22da-4d00-b573-ca730b3f47ea', 'Reading', NULL, '16.	The word ‘extensively’ in line 19 is closest in meaning to', '{\"a\":\"a.\\tlarge \",\"b\":\"b.\\tlarger \",\"c\":\"c.\\tlargely \",\"d\":\"d.\\tlargest\"}', 'a', '', NULL, NULL, NULL),
('fa917bab-dc57-4948-863f-e33b5789a955', 'Reading', NULL, '46. According to the passage, an exuberant tone of voice, may be an indication of a person’s ', '{\"a\":\"a.\\tgeneral physical health  \",\"b\":\"b.\\tpersonality  \",\"c\":\"c.\\tability to communicate \",\"d\":\"d.\\tvocal quality \"}', 'a', '', NULL, NULL, NULL),
('fac853e1-6008-4f99-80b9-18a243b3e771', 'Reading', NULL, 'What does the author mean by stating that “At interpersonal levels, tone   may reflect ideas and feelings over and above the words chosen” (lines 9-10)? ', '{\"a\":\"a.\\tFeelings are expressed with different words than ideas are.  \",\"b\":\"b.\\tThe tone of voice can carry information beyond the meaning of words.\",\"c\":\"c.\\tA high tone of voice reflects an emotional communication.  \",\"d\":\"d.\\tFeelings are more difficult to express than ideas.\"}', 'a', '', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `score_conversions`
--

CREATE TABLE `score_conversions` (
  `id` int(11) NOT NULL,
  `section` varchar(255) NOT NULL,
  `rawScore` int(11) NOT NULL,
  `scaledScore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `test_attempts`
--

CREATE TABLE `test_attempts` (
  `id` varchar(36) NOT NULL,
  `userId` varchar(255) NOT NULL,
  `packageId` varchar(255) NOT NULL,
  `date` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `durationSeconds` int(11) NOT NULL,
  `answers` text NOT NULL,
  `rawScores` text DEFAULT NULL,
  `scaledScores` text DEFAULT NULL,
  `totalScore` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `test_attempts`
--

INSERT INTO `test_attempts` (`id`, `userId`, `packageId`, `date`, `durationSeconds`, `answers`, `rawScores`, `scaledScores`, `totalScore`) VALUES
('a23c9c0d-575c-462d-8ce7-dfbc00544362', 'e6aeab06-e370-41ad-a95b-ad74a4a71a17', '1f7c62b6-53af-418e-b5c7-04495ade651f', '2026-06-17 09:17:36.166189', 0, '{}', '{\"listening\":30,\"structure\":25,\"reading\":40}', '{\"listening\":50,\"structure\":45,\"reading\":55}', 500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `test_packages`
--

CREATE TABLE `test_packages` (
  `id` varchar(36) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `questions` text NOT NULL,
  `durations` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `test_packages`
--

INSERT INTO `test_packages` (`id`, `name`, `type`, `questions`, `durations`, `status`) VALUES
('1b8cc1bb-e329-4373-b837-14f399acf474', 'TOEFL ITP Simulation - Full Test #2', 'Full Test', '{\"listening\":[],\"structure\":[],\"reading\":[]}', '{\"listening\":2100,\"structure\":1500,\"reading\":3300}', 'published'),
('1f7c62b6-53af-418e-b5c7-04495ade651f', 'TOEFL ITP Simulation - Full Test #1', 'Full Test', '{\"listening\":[],\"structure\":[],\"reading\":[]}', '{\"listening\":2100,\"structure\":1500,\"reading\":3300}', 'published'),
('65b57a9f-540f-489d-a68c-0e0e0cd9d8c7', 'Latihan Listening Comprehension', 'Section Practice', '{\"listening\":[]}', '{\"listening\":2100}', 'published'),
('b897c10c-7c81-44d3-b6de-9a58b8d641b4', 'Latihan Reading Comprehension', 'Section Practice', '{\"reading\":[]}', '{\"reading\":3300}', 'published'),
('ec68c304-67de-4fd3-934f-ef2a78bdab0a', 'Latihan Structure & Written Expression', 'Section Practice', '{\"structure\":[]}', '{\"structure\":1500}', 'published');

-- --------------------------------------------------------

--
-- Struktur dari tabel `test_requests`
--

CREATE TABLE `test_requests` (
  `id` varchar(36) NOT NULL,
  `userId` varchar(255) NOT NULL,
  `packageId` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'PENDING',
  `createdAt` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `updatedAt` datetime(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` varchar(36) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'student',
  `createdAt` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `updatedAt` datetime(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `passwordHash`, `role`, `createdAt`, `updatedAt`) VALUES
('1efc24e8-69f6-11f1-8699-bc24117f0646', 'Super Admin', 'admin@cordova.ac.id', '$2b$10$FkUBugCPBCpFQ81JdlCB5uWkaH4fOCz7ddRR8qHt.8Lpr1U0SUWxO', 'admin', '2026-06-17 09:42:02.000000', '2026-06-17 09:42:02.000000'),
('293d4807-6a09-11f1-8699-bc24117f0646', 'Admin 1', 'admin1@cordova.ac.id', '$2b$10$FkUBugCPBCpFQ81JdlCB5uWkaH4fOCz7ddRR8qHt.8Lpr1U0SUWxO', 'admin', '2026-06-17 11:58:20.000000', '2026-06-17 11:58:20.000000'),
('294d725a-6a09-11f1-8699-bc24117f0646', 'Admin 2', 'admin2@cordova.ac.id', '$2b$10$FkUBugCPBCpFQ81JdlCB5uWkaH4fOCz7ddRR8qHt.8Lpr1U0SUWxO', 'admin', '2026-06-17 11:58:20.000000', '2026-06-17 11:58:20.000000'),
('92014d34-ae5c-4545-a31c-8e6db42f637b', 'Demo Mahasiswa', 'mahasiswa@cordova.ac.id', '$2b$10$gOVvpCUcy162SLsF2oSmaOXUg3NifgbVjawEIAp4qlH5AsctzzGVu', 'student', '2026-06-17 09:51:33.548308', '2026-06-17 09:51:33.548308'),
('e6aeab06-e370-41ad-a95b-ad74a4a71a17', 'muhammad akmal', 'admin@admin.com', '$2b$10$xJElwdQLkb5GHWxwWuozR.p3hVRT8KWZRpmHolBROZj5dgKCV3TUO', 'student', '2026-06-17 09:16:09.101984', '2026-06-17 09:16:09.101984');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `audios`
--
ALTER TABLE `audios`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `passages`
--
ALTER TABLE `passages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_8bb38cb4c87763267393429c767` (`audioId`),
  ADD KEY `FK_9639bdb4fa738fcb27904b8ddac` (`passageId`),
  ADD KEY `FK_c8b7b8f7216615f81e66ce511ae` (`packageId`);

--
-- Indeks untuk tabel `score_conversions`
--
ALTER TABLE `score_conversions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `test_attempts`
--
ALTER TABLE `test_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_c2d6de3ee467f1b42f22a30d5a4` (`userId`),
  ADD KEY `FK_5eef4c2419ee6d36f5cea5b4f41` (`packageId`);

--
-- Indeks untuk tabel `test_packages`
--
ALTER TABLE `test_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `test_requests`
--
ALTER TABLE `test_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IDX_97672ac88f789774dd47f7c8be` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `score_conversions`
--
ALTER TABLE `score_conversions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `FK_8bb38cb4c87763267393429c767` FOREIGN KEY (`audioId`) REFERENCES `audios` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_9639bdb4fa738fcb27904b8ddac` FOREIGN KEY (`passageId`) REFERENCES `passages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_c8b7b8f7216615f81e66ce511ae` FOREIGN KEY (`packageId`) REFERENCES `test_packages` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `test_attempts`
--
ALTER TABLE `test_attempts`
  ADD CONSTRAINT `FK_5eef4c2419ee6d36f5cea5b4f41` FOREIGN KEY (`packageId`) REFERENCES `test_packages` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_c2d6de3ee467f1b42f22a30d5a4` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
