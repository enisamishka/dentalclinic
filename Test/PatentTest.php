<?php
require_once 'Patient.php'; // Include the class file to be tested
require_once 'MockPDO.php'; // Include mock PDO class for testing

use PHPUnit\Framework\TestCase;

class PatientTest extends TestCase
{
    protected $patient;

    protected function setUp()
    {
        // Initialize the class with a mock database connection
        $this->patient = new Patient(MockPDO::class);
    }

    public function testGetPatientById()
    {
        // Mock the database connection and prepare statement behavior
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())->method('execute')->willReturn(true);
        $stmt->expects($this->once())->method('fetch')->willReturn(['patient_id' => 1, 'full_name' => 'Enisa Mishka']);

        $pdo = $this->createMock(MockPDO::class);
        $pdo->expects($this->once())->method('prepare')->willReturn($stmt);

        // Replace the database connection with the mock
        $this->patient->dbh = $pdo;

        // Test the method
        $result = $this->patient->getPatientById(1);
        $this->assertEquals(['patient_id' => 1, 'full_name' => 'John Doe'], $result);
    }

    public function testRegisterPatient()
    {
        // Mock the database connection and prepare statement behavior
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())->method('execute')->willReturn(true);

        $pdo = $this->createMock(MockPDO::class);
        $pdo->expects($this->once())->method('prepare')->willReturn($stmt);

        // Replace the database connection with the mock
        $this->patient->dbh = $pdo;

        // Test the method
        $result = $this->patient->registerPatient("Enisa Mishka", "enisamishka@gmail.com", "123456789", "2003-06-01", "Address", "active", 1);
        $this->assertTrue($result);
    }
}
?>
