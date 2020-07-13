<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class VideoConvert extends Command
{
    protected $signature = 'video:convert';
    
    protected $description = 'Command description';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        $shell     = shell_exec("$ffmpeg_b -y -i $video_file_full_path -vcodec libx264 -preset {$pt->config->convert_speed} -filter:v scale=426:-2 -crf 26 $video_output_full_path_240 2>&1");
        $upload_s3 = PT_UploadToS3($filepath . "_240p_converted.mp4");
        $db->where('id', $video->id);
        $db->update(T_VIDEOS, array(
            'converted' => 1,
            '240p' => 1,
            'video_location' => $filepath . "_240p_converted.mp4"
        ));
        $db->where('video_id',$video->id)->delete(T_QUEUE);
    
        if ($video_res >= 640 || $video_res == 0) {
            $shell                      = shell_exec("$ffmpeg_b -y -i $video_file_full_path -vcodec libx264 -preset {$pt->config->convert_speed} -filter:v scale=640:-2 -crf 26 $video_output_full_path_360 2>&1");
            $upload_s3                  = PT_UploadToS3($filepath . "_360p_converted.mp4");
            $db->where('id', $video->id);
            $db->update(T_VIDEOS, array(
                '360p' => 1,
            ));
        }
    
        if ($video_res >= 854 || $video_res == 0) {
            $shell     = shell_exec("$ffmpeg_b -y -i $video_file_full_path -vcodec libx264 -preset {$pt->config->convert_speed} -filter:v scale=854:-2 -crf 26 $video_output_full_path_480 2>&1");
            $upload_s3 = PT_UploadToS3($filepath . "_480p_converted.mp4");
            $db->where('id', $video->id);
            $db->update(T_VIDEOS, array(
                '480p' => 1
            ));
        }
    
        if ($video_res >= 1280 || $video_res == 0) {
            $shell     = shell_exec("$ffmpeg_b -y -i $video_file_full_path -vcodec libx264 -preset {$pt->config->convert_speed} -filter:v scale=1280:-2 -crf 26 $video_output_full_path_720 2>&1");
            $upload_s3 = PT_UploadToS3($filepath . "_720p_converted.mp4");
            $db->where('id', $video->id);
            $db->update(T_VIDEOS, array(
                '720p' => 1
            ));
        }
    
        if ($video_res >= 1920 || $video_res == 0) {
            $shell     = shell_exec("$ffmpeg_b -y -i $video_file_full_path -vcodec libx264 -preset {$pt->config->convert_speed} -filter:v scale=1920:-2 -crf 26 $video_output_full_path_1080 2>&1");
            $upload_s3 = PT_UploadToS3($filepath . "_1080p_converted.mp4");
            $db->where('id', $video->id);
            $db->update(T_VIDEOS, array(
                '1080p' => 1
            ));
        }
    
        if ($video_res >= 2048) {
            $shell     = shell_exec("$ffmpeg_b -y -i $video_file_full_path -vcodec libx264 -preset {$pt->config->convert_speed} -filter:v scale=2048:-2 -crf 26 $video_output_full_path_2048 2>&1");
            $upload_s3 = PT_UploadToS3($filepath . "_2048p_converted.mp4");
            $db->where('id', $video->id);
            $db->update(T_VIDEOS, array(
                '2048p' => 1
            ));
        }
    
        if ($video_res >= 3840) {
            $shell     = shell_exec("$ffmpeg_b -y -i $video_file_full_path -vcodec libx264 -preset {$pt->config->convert_speed} -filter:v scale=3840:-2 -crf 26 $video_output_full_path_4096 2>&1");
            $upload_s3 = PT_UploadToS3($filepath . "_4096p_converted.mp4");
            $db->where('id', $video->id);
            $db->update(T_VIDEOS, array(
                '4096p' => 1
            ));
        }
    }
}
