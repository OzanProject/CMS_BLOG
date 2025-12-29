<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BackupController extends Controller
{
    public function index()
    {
        return view('admin.backups.index');
    }

    public function store()
    {
        $dbName = config('database.connections.mysql.database');
        $tables = DB::select('SHOW TABLES');
        $tableKey = "Tables_in_" . $dbName;
        
        $sql = "-- Database Backup: " . $dbName . "\n";
        $sql .= "-- Date: " . now() . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = $table->$tableKey;
            
            // Skip views if any (optional)
            
            // 1. Drop Table
            $sql .= "DROP TABLE IF EXISTS `$tableName`;\n";

            // 2. Create Table Structure
            $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0];
            $sql .= $createTable->{'Create Table'} . ";\n\n";

            // 3. Insert Data
            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    if (is_null($value)) return "NULL";
                    return "'" . addslashes($value) . "'";
                }, (array) $row);
                
                $sql .= "INSERT INTO `$tableName` VALUES (" . implode(", ", $values) . ");\n";
            }
            $sql .= "\n\n";
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

        $fileName = 'backup-' . date('Y-m-d-H-i-s') . '.sql';

        return response()->streamDownload(function () use ($sql) {
            echo $sql;
        }, $fileName);
    }

    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|mimes:sql,txt',
        ]);

        $path = $request->file('backup_file')->getRealPath();
        $sql = file_get_contents($path);

        try {
            DB::unprepared($sql);
            return back()->with('success', 'Database restored successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Restore failed: ' . $e->getMessage());
        }
    }

    public function reset()
    {
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            // Truncate tables except users, pages, and configurations
            DB::table('articles')->truncate();
            DB::table('categories')->truncate();
            DB::table('comments')->truncate();
            DB::table('messages')->truncate();
            DB::table('subscribers')->truncate();
            DB::table('tasks')->truncate();
            
            // Add other tables here if needed (e.g. tags)

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return back()->with('success', 'Website data reset successfully! (Users & Pages preserved)');
        } catch (\Exception $e) {
            return back()->with('error', 'Reset failed: ' . $e->getMessage());
        }
    }
}
