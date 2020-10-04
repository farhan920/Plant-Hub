<?php
    class Controller {
        /** @var PDO db */
        private $db;
        function __construct($db) {

            $this->db = $db;
        }

        public function process($airtemp, $ppm, $waterph, $watertemp) {
            $date = new DateTime();
            $average = $this->getAverageData(30);
            $open1 = '00.00';
            $open2 = '00.00';
            if ($date->format('i') == 44 || $date->format('i') == 1) {
                if ($average['ppm'] < 5000) {
                    $open1 = '30.00';
                }

                if ($average['waterph'] < 7) {
                    $open2 = '30.00';
                }
            }
            return implode(',', array($open1, $open2));
        }

        public function postData($airtemp, $ppm, $waterph, $watertemp) {
            $stmt = $this->db->prepare('INSERT INTO phbase (timestamp, airtemp, ppm, watertemp, waterph) VAlUES (:timestamp, :airtemp, :ppm, :watertemp, :waterph)');
            $stmt->bindValue(':timestamp', time(), PDO::PARAM_INT);
            $stmt->bindValue(':airtemp', $airtemp, PDO::PARAM_STR);
            $stmt->bindValue(':ppm', $ppm, PDO::PARAM_STR);
            $stmt->bindValue(':waterph', $waterph, PDO::PARAM_STR);
            $stmt->bindValue(':watertemp', $watertemp, PDO::PARAM_STR);
            if ($stmt->execute()) {
                return array('success' => true);
            } else {
                error_log('postData failed');
                return array('success' => false);
            }
        }

        public function getData() {
            $stmt = $this->db->prepare('SELECT * FROM phbase ORDER BY timestamp DESC LIMIT 1');
            if ($stmt->execute()) {
                return array('success' => true, 'result' => $stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                error_log('getData failed');
                return array('success' => false);
            }
        }

        public function getAllData() {
            $stmt = $this->db->prepare('SELECT * FROM phbase');
            if ($stmt->execute()) {
                return array('success' => true, 'result' => $stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                error_log('getAllData failed');
                return array('success' => false);
            }
        }

        public function getAverageData($limit) {
            $stmt = $this->db->prepare('SELECT AVG(airtemp) as airtemp, AVG(ppm) as ppm, AVG(waterph) as waterph, AVG(watertemp) as watertemp FROM phbase ORDER BY timestamp DESC LIMIT :limit');
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return array('success' => true, 'result' => $stmt->fetch(PDO::FETCH_ASSOC));
            } else {
                error_log('getAverageData failed');
                return array('success' => false);
            }
        }

        public function getHistoricalData($limit) {
            $stmt = $this->db->prepare('SELECT * FROM phbase ORDER BY timestamp DESC LIMIT :limit');
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return array('success' => true, 'result' => $stmt->fetchAll(PDO::FETCH_ASSOC));
            } else {
                error_log('getAverageData failed');
                return array('success' => false);
            }
        }
    }