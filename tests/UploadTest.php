<?php

use App\Utility\Upload;
use PHPUnit\Framework\TestCase;

class UploadTest extends TestCase
{
    public function testUploadFile()
    {
        $file = [
            'name' => 'test_file',
            'size' => 1024,
            'tmp_name' => '/tmp/test_file.tmp',
            'error' => 0
        ];
        $fileName = 'myfile';
        $fileExtension = 'txt';

        $currentDirectory = getcwd();
        $uploadDirectory = "/storage/";
        $expectedPictureName = $fileName . '.' . $fileExtension;
        $expectedUploadPath = $currentDirectory . $uploadDirectory . $expectedPictureName;

        $moveUploadedFileCalled = false;

        // Mocking the moveUploadedFile() method
        $uploadUtilityMock = $this->getMockBuilder(Upload::class)
            ->addMethods(['moveUploadedFile'])
            ->getMock();

        $uploadUtilityMock->expects($this->once())
            ->method('moveUploadedFile')
            ->with($file['tmp_name'], $expectedUploadPath)
            ->willReturnCallback(function () use (&$moveUploadedFileCalled) {
                $moveUploadedFileCalled = true;
                return true;
            });

        // $this->assertEquals($expectedPictureName, $uploadUtilityMock->uploadFile($file, $fileName, $fileExtension));
        $this->assertTrue($moveUploadedFileCalled);
    }
}
