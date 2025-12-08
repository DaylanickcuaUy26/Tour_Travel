<?php

require_once(ROOT . '/core/Model.php');

class PackageModel extends Model {
    public function getFeaturedPackages($limit = 4) {
        $sql = "SELECT * FROM tbltourpackages ORDER BY rand() LIMIT :limit";
        $query = $this->db->prepare($sql);
        $query->bindParam(':limit', $limit, PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getDistinctLocations() {
        $sql = "SELECT DISTINCT PackageLocation FROM tbltourpackages WHERE PackageLocation <> '' ORDER BY PackageLocation";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getFilteredPackages($keyword, $location, $price) {
        $sql = "SELECT * FROM tbltourpackages WHERE 1=1";
        if($keyword !== '') {
            $sql .= " AND PackageName LIKE :keyword";
        }
        if($location !== '') {
            $sql .= " AND PackageLocation = :location";
        }
        if($price === 'under-200') {
            $sql .= " AND PackagePrice < 200";
        } elseif($price === '200-500') {
            $sql .= " AND PackagePrice BETWEEN 200 AND 500";
        } elseif($price === 'over-500') {
            $sql .= " AND PackagePrice > 500";
        }
        $sql .= " ORDER BY Creationdate DESC";

        $query = $this->db->prepare($sql);
        if($keyword !== '') {
            $likeKeyword = "%".$keyword."%";
            $query->bindParam(':keyword', $likeKeyword, PDO::PARAM_STR);
        }
        if($location !== '') {
            $query->bindParam(':location', $location, PDO::PARAM_STR);
        }
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getPackageById($id) {
        $sql = "SELECT * from tbltourpackages where PackageId=:id";
        $query = $this->db->prepare($sql);
        $query->bindParam(':id', $id, PDO::PARAM_INT);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }
}
