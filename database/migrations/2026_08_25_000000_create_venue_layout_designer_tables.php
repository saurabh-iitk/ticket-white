<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenueLayoutDesignerTables extends Migration
{
    public function up()
    {
        // 1. Create Pricing Categories Table
        Schema::create('pricing_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->decimal('price', 10, 2);
            $table->string('currency', 3)->default('INR');
            $table->string('color', 7);
            $table->timestamps();
        });

        // 2. Create Sections Table
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->integer('layout_id');
            $table->string('name', 100);
            $table->string('code', 50);
            $table->integer('capacity')->default(0);
            $table->unsignedBigInteger('pricing_category_id')->nullable();
            $table->string('color', 7)->default('#3b82f6');
            $table->decimal('x', 8, 2)->default(0.00);
            $table->decimal('y', 8, 2)->default(0.00);
            $table->decimal('w', 8, 2)->default(100.00);
            $table->decimal('h', 8, 2)->default(100.00);
            $table->decimal('rotation', 8, 2)->default(0.00);
            $table->timestamps();
        });

        // 3. Add Columns to layout_details
        Schema::table('layout_details', function (Blueprint $table) {
            if (!Schema::hasColumn('layout_details', 'section_id')) {
                $table->unsignedBigInteger('section_id')->nullable()->after('layout_id');
            }
            if (!Schema::hasColumn('layout_details', 'seat_type')) {
                $table->string('seat_type', 50)->default('REGULAR')->after('section_id');
            }
            if (!Schema::hasColumn('layout_details', 'x')) {
                $table->decimal('x', 8, 2)->nullable()->after('seat_type');
            }
            if (!Schema::hasColumn('layout_details', 'y')) {
                $table->decimal('y', 8, 2)->nullable()->after('x');
            }
            if (!Schema::hasColumn('layout_details', 'w')) {
                $table->integer('w')->default(32)->after('y');
            }
            if (!Schema::hasColumn('layout_details', 'h')) {
                $table->integer('h')->default(32)->after('w');
            }
            if (!Schema::hasColumn('layout_details', 'rotation')) {
                $table->decimal('rotation', 8, 2)->default(0.00)->after('h');
            }
        });

        // 4. Add Columns to event_seat
        Schema::table('event_seat', function (Blueprint $table) {
            if (!Schema::hasColumn('event_seat', 'section_id')) {
                $table->unsignedBigInteger('section_id')->nullable()->after('layout_id');
            }
            if (!Schema::hasColumn('event_seat', 'seat_type')) {
                $table->string('seat_type', 50)->default('REGULAR')->after('section_id');
            }
            if (!Schema::hasColumn('event_seat', 'x')) {
                $table->decimal('x', 8, 2)->nullable()->after('seat_type');
            }
            if (!Schema::hasColumn('event_seat', 'y')) {
                $table->decimal('y', 8, 2)->nullable()->after('x');
            }
            if (!Schema::hasColumn('event_seat', 'w')) {
                $table->integer('w')->default(32)->after('y');
            }
            if (!Schema::hasColumn('event_seat', 'h')) {
                $table->integer('h')->default(32)->after('w');
            }
            if (!Schema::hasColumn('event_seat', 'rotation')) {
                $table->decimal('rotation', 8, 2)->default(0.00)->after('h');
            }
            if (!Schema::hasColumn('event_seat', 'pricing_category_id')) {
                $table->unsignedBigInteger('pricing_category_id')->nullable()->after('event_ticket_type_id');
            }
        });
    }

    public function down()
    {
        Schema::table('event_seat', function (Blueprint $table) {
            $table->dropColumn(['section_id', 'seat_type', 'x', 'y', 'w', 'h', 'rotation', 'pricing_category_id']);
        });

        Schema::table('layout_details', function (Blueprint $table) {
            $table->dropColumn(['section_id', 'seat_type', 'x', 'y', 'w', 'h', 'rotation']);
        });

        Schema::dropIfExists('sections');
        Schema::dropIfExists('pricing_categories');
    }
}
