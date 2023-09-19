<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Media;

class AddFrontSectionContentInMediaTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media', function (Blueprint $table) {

            $table->enum('is_section_content', ['yes', 'no'])->default('no')->nullable()->after('file_name');
            $table->enum('have_content', ['yes', 'no'])->default('no')->nullable()->after('is_section_content');
            $table->longText('section_title')->nullable()->after('have_content');
            $table->longText('title_note')->nullable()->after('section_title');
            $table->longText('section_content')->nullable()->after('title_note');
            $table->enum('content_alignment', ['left', 'right'])->default('left')->nullable();
        });

        $sectionContent = new Media();
        $sectionContent->file_name = 'section_image.jpg';
        $sectionContent->have_content = 'yes';
        $sectionContent->is_section_content = 'yes';
        $sectionContent->title_note = 'Lorem ipsum dolor sut amet';
        $sectionContent->section_title = 'Hair Spa and Hair Cut';
        $sectionContent->section_content = '<p><span style="font-size: 12px;">﻿</span><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla feugiat hendrerit lectus vitae ornare. Maecenas mauris turpis, pellentesque nec dictum consectetur, s</span><span style="font-size: 12px;">﻿</span><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">emper vitae tortor. Aliquam nunc turpis, tristique at felis eget, dapibus aliquet massa. Fusce nec feugiat arcu, quis varius libero.</span></p><p><span style="font-size: 12px;">﻿</span><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 11px; text-align: justify;"><br></span></p><ul><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Quisque orci sapien, aliquet sit amet fringilla quis, efficitur eu est. Suspendisse at dictum purus</span></li><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Phasellus sit amet enim sed sem maximus lobortis. Nam vehicula facilisis fringilla.</span></li><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Nunc et quam id sem pharetra feugiat. Nullam imperdiet congue diam, vel tempor sit amet.</span></li><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Aenean a mi eu ipsum ullamcorper venenatis. Nulla dictum libero, eu cursus leo lacinia sed.</span></li><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Nulla ipsum lorem, maximus in risus sit amet, bibendum molestie dolor.</span></li><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Pellentesque vestibulum dapibus ipsum id aliquet.</span></li></ul>';
        $sectionContent->content_alignment = 'left';
        $sectionContent->save();

        $sectionContent = new Media();
        $sectionContent->file_name = 'section_image_1.jpg';
        $sectionContent->have_content = 'yes';
        $sectionContent->is_section_content = 'yes';
        $sectionContent->title_note = 'Lorem ipsum dolor sut amet';
        $sectionContent->section_title = 'Hair Spa and Hair Cut';
        $sectionContent->section_content = '<p><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;">Donec id nunc nulla. Praesent ac ligula ut augue mollis sollicitudin. Vestibulum sit amet nisl auctor, finibus odio id, pretium nunc. Praesent ut pellentesque ligula. Sed vitae lorem tempus, aliquet magna ac, scelerisque dui. Integer sed nunc eu sem porta faucibus. Donec vel vestibulum orci&nbsp;</span><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;">&nbsp;</span><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;">pellentesque ligula.</span></p><p><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;"><br></span><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;">Praesent ac ligula ut augue mollis sollicitudin. Vestibulum sit amet nisl auctor, finibus odio id, pretium nunc. Praesent ut.</span></p><p><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;"><br></span><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 14px; text-align: justify;">Donec iaculis justo arcu, ac egestas dui molestie eu. Curabitur sodales placerat eros vitae cursus.</span></p>';
        $sectionContent->content_alignment = 'right';
        $sectionContent->save();

        $sectionContent = new Media();
        $sectionContent->file_name = 'section_image.jpg';
        $sectionContent->have_content = 'yes';
        $sectionContent->is_section_content = 'yes';
        $sectionContent->title_note = 'Lorem ipsum dolor sut amet';
        $sectionContent->section_title = 'Hair Spa and Hair Cut';
        $sectionContent->section_content = '<p><span style="font-size: 12px;">﻿</span><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla feugiat hendrerit lectus vitae ornare. Maecenas mauris turpis, pellentesque nec dictum consectetur, s</span><span style="font-size: 12px;">﻿</span><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">emper vitae tortor. Aliquam nunc turpis, tristique at felis eget, dapibus aliquet massa. Fusce nec feugiat arcu, quis varius libero.</span></p><p><span style="font-size: 12px;">﻿</span><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 11px; text-align: justify;"><br></span></p><ul><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Quisque orci sapien, aliquet sit amet fringilla quis, efficitur eu est. Suspendisse at dictum purus</span></li><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Phasellus sit amet enim sed sem maximus lobortis. Nam vehicula facilisis fringilla.</span></li><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Nunc et quam id sem pharetra feugiat. Nullam imperdiet congue diam, vel tempor sit amet.</span></li><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Aenean a mi eu ipsum ullamcorper venenatis. Nulla dictum libero, eu cursus leo lacinia sed.</span></li><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Nulla ipsum lorem, maximus in risus sit amet, bibendum molestie dolor.</span></li><li><span style="font-family: &quot;Open Sans&quot;, Arial, sans-serif; font-size: 12px; text-align: justify;">Pellentesque vestibulum dapibus ipsum id aliquet.</span></li></ul>';
        $sectionContent->content_alignment = 'left';
        $sectionContent->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('section_content');
            $table->dropColumn('have_content');
            $table->dropColumn('is_section_content');
            $table->dropColumn('title_note');
            $table->dropColumn('section_title');
            $table->dropColumn('content_alignment');
        });
    }

}
