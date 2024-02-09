<?php

// use SajedZarinpour\SpotPlayer\Facades\SpotPlayer;

test('get course detail', function ($courseId) {
    
    $data = spotplayer()->getCourseDetail($courseId);
    self::assertArrayHasKey(
        $key='_id', 
        $data, 
        $message = 'Key Not Found.'
    );
    self::assertEquals(
        $expected = $courseId,
        $actual = $data['_id'],
        $message = 'Value Does Not Match.' 
    );
})->with('provide_getCourseDetail_data');

dataset('provide_getCourseDetail_data', function () {
    return [
        [
            'courseId',
        ]
    ];
});
