<?php

namespace App;

use App\Student;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $fillable = [
        'code',
        'name',
        'maximum_students',
        'status',
        'description'     
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function addStudent(Student $student)
    {
        return $this->students()->save($student);
    }

    /**
     * @param $id
     * @return array
     */
    public function deleteStudent($studentId)
    {
        $this->students()->find($studentId)->delete();
        return ["message"=>"The student has been deleted"];
    }

    /**
     * @param $id
     * @return int
     */
    public function hasDuplicateStudent($categoryId)
    {
        return $this->students()->find($studentId)->count();
    }

    /**
     * @return int
     */
    public function countStudents()
    {
        return $this->students()->count();
    }

}
