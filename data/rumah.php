<?
class Rumah {
	private $id;
	private $nama;
	private $alamat;
	private $latitude;
	private $longitude;
	private $telp;
	private $keterangan;

	public function __construct() {
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setNama($nama) {
		$this->nama = $nama;
	}

	public function getNama() {
		return $this->nama;
	}

	public function setAlamat($alamat) {
		$this->alamat = $alamat;
	}

	public function getAlamat() {
		return $this->alamat;
	}

	public function setLatitude($latitude) {
		$this->latitude = $latitude;
	}

	public function getLatitude() {
		return $this->latitude;
	}

	public function setLongitude($longitude) {
		$this->longitude = $longitude;
	}

	public function getLongitude() {
		return $this->longitude;
	}

	public function setTelp($telp) {
		$this->telp = $telp;
	}

	public function getTelp() {
		return $this->telp;
	}

	public function setKeterangan($keterangan) {
		$this->keterangan = $keterangan;
	}

	public function getKeterangan() {
		return $this->keterangan;
	}
}

?>