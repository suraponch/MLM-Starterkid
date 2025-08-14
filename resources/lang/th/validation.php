<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'ต้องยอมรับ :attribute',
    'active_url' => ':attribute ไม่ใช่ URL ที่ถูกต้อง',
    'after' => ':attribute ต้องเป็นวันที่หลัง :date',
    'after_or_equal' => ':attribute ต้องเป็นวันที่หลังหรือเท่ากับ :date',
    'alpha' => ':attribute ต้องมีเฉพาะตัวอักษรเท่านั้น',
    'alpha_dash' => ':attribute ต้องมีเฉพาะตัวอักษร, ตัวเลข, ขีดกลาง, และขีดล่างเท่านั้น',
    'alpha_num' => ':attribute ต้องมีเฉพาะตัวอักษรและตัวเลขเท่านั้น',
    'array' => ':attribute ต้องเป็นอาร์เรย์',
    'before' => ':attribute ต้องเป็นวันที่ก่อน :date',
    'before_or_equal' => ':attribute ต้องเป็นวันที่ก่อนหรือเท่ากับ :date',
    'between' => [
        'numeric' => ':attribute ต้องอยู่ระหว่าง :min และ :max',
        'file' => ':attribute ต้องมีขนาดระหว่าง :min และ :max กิโลไบต์',
        'string' => ':attribute ต้องมีความยาวระหว่าง :min และ :max ตัวอักษร',
        'array' => ':attribute ต้องมีจำนวนรายการระหว่าง :min และ :max รายการ',
    ],
    'boolean' => 'ฟิลด์ :attribute ต้องเป็นจริงหรือเท็จ',
    'confirmed' => 'การยืนยัน :attribute ไม่ตรงกัน',
    'date' => ':attribute ไม่ใช่วันที่ที่ถูกต้อง',
    'date_format' => ':attribute ไม่ตรงกับรูปแบบ :format',
    'different' => ':attribute และ :other ต้องแตกต่างกัน',
    'digits' => ':attribute ต้องเป็น :digits หลัก',
    'digits_between' => ':attribute ต้องอยู่ระหว่าง :min และ :max หลัก',
    'dimensions' => ':attribute มีขนาดรูปภาพไม่ถูกต้อง',
    'distinct' => 'ฟิลด์ :attribute มีค่าซ้ำกัน',
    'email' => ':attribute ต้องเป็นอีเมลแอดเดรสที่ถูกต้อง',
    'exists' => ':attribute ที่เลือกไม่ถูกต้อง',
    'file' => ':attribute ต้องเป็นไฟล์',
    'filled' => 'ฟิลด์ :attribute ต้องมีค่า',
    'gt' => [
        'numeric' => ':attribute ต้องมากกว่า :value',
        'file' => ':attribute ต้องมีขนาดใหญ่กว่า :value กิโลไบต์',
        'string' => ':attribute ต้องยาวกว่า :value ตัวอักษร',
        'array' => ':attribute ต้องมีมากกว่า :value รายการ',
    ],
    'gte' => [
        'numeric' => ':attribute ต้องมากกว่าหรือเท่ากับ :value',
        'file' => ':attribute ต้องมีขนาดมากกว่าหรือเท่ากับ :value กิโลไบต์',
        'string' => ':attribute ต้องยาวมากกว่าหรือเท่ากับ :value ตัวอักษร',
        'array' => ':attribute ต้องมี :value รายการหรือมากกว่า',
    ],
    'image' => ':attribute ต้องเป็นรูปภาพ',
    'in' => ':attribute ที่เลือกไม่ถูกต้อง',
    'in_array' => 'ฟิลด์ :attribute ไม่มีอยู่ใน :other',
    'integer' => ':attribute ต้องเป็นจำนวนเต็ม',
    'ip' => ':attribute ต้องเป็น IP address ที่ถูกต้อง',
    'ipv4' => ':attribute ต้องเป็น IPv4 address ที่ถูกต้อง',
    'ipv6' => ':attribute ต้องเป็น IPv6 address ที่ถูกต้อง',
    'json' => ':attribute ต้องเป็น JSON string ที่ถูกต้อง',
    'lt' => [
        'numeric' => ':attribute ต้องน้อยกว่า :value',
        'file' => ':attribute ต้องมีขนาดน้อยกว่า :value กิโลไบต์',
        'string' => ':attribute ต้องยาวน้อยกว่า :value ตัวอักษร',
        'array' => ':attribute ต้องมีน้อยกว่า :value รายการ',
    ],
    'lte' => [
        'numeric' => ':attribute ต้องน้อยกว่าหรือเท่ากับ :value',
        'file' => ':attribute ต้องมีขนาดน้อยกว่าหรือเท่ากับ :value กิโลไบต์',
        'string' => ':attribute ต้องยาวน้อยกว่าหรือเท่ากับ :value ตัวอักษร',
        'array' => ':attribute ต้องมีไม่เกิน :value รายการ',
    ],
    'max' => [
        'numeric' => ':attribute ต้องไม่มากกว่า :max',
        'file' => ':attribute ต้องมีขนาดไม่เกิน :max กิโลไบต์',
        'string' => ':attribute ต้องมีความยาวไม่เกิน :max ตัวอักษร',
        'array' => ':attribute ต้องมีไม่เกิน :max รายการ',
    ],
    'mimes' => ':attribute ต้องเป็นไฟล์ประเภท: :values',
    'mimetypes' => ':attribute ต้องเป็นไฟล์ประเภท: :values',
    'min' => [
        'numeric' => ':attribute ต้องมีค่าอย่างน้อย :min',
        'file' => ':attribute ต้องมีขนาดอย่างน้อย :min กิโลไบต์',
        'string' => ':attribute ต้องมีความยาวอย่างน้อย :min ตัวอักษร',
        'array' => ':attribute ต้องมีอย่างน้อย :min รายการ',
    ],
    'not_in' => ':attribute ที่เลือกไม่ถูกต้อง',
    'not_regex' => 'รูปแบบ :attribute ไม่ถูกต้อง',
    'numeric' => ':attribute ต้องเป็นตัวเลข',
    'present' => 'ฟิลด์ :attribute ต้องมีอยู่',
    'regex' => 'รูปแบบ :attribute ไม่ถูกต้อง',
    'required' => 'ฟิลด์ :attribute เป็นฟิลด์บังคับ',
    'required_if' => 'ฟิลด์ :attribute เป็นฟิลด์บังคับเมื่อ :other คือ :value',
    'required_unless' => 'ฟิลด์ :attribute เป็นฟิลด์บังคับยกเว้น :other อยู่ใน :values',
    'required_with' => 'ฟิลด์ :attribute เป็นฟิลด์บังคับเมื่อมี :values',
    'required_with_all' => 'ฟิลด์ :attribute เป็นฟิลด์บังคับเมื่อมี :values ทั้งหมด',
    'required_without' => 'ฟิลด์ :attribute เป็นฟิลด์บังคับเมื่อไม่มี :values',
    'required_without_all' => 'ฟิลด์ :attribute เป็นฟิลด์บังคับเมื่อไม่มี :values ใดๆ',
    'same' => ':attribute และ :other ต้องตรงกัน',
    'size' => [
        'numeric' => ':attribute ต้องมีขนาด :size',
        'file' => ':attribute ต้องมีขนาด :size กิโลไบต์',
        'string' => ':attribute ต้องมีความยาว :size ตัวอักษร',
        'array' => ':attribute ต้องประกอบด้วย :size รายการ',
    ],
    'string' => ':attribute ต้องเป็นสตริง',
    'timezone' => ':attribute ต้องเป็นเขตเวลาที่ถูกต้อง',
    'unique' => 'มี :attribute นี้อยู่แล้ว',
    'uploaded' => 'การอัปโหลด :attribute ล้มเหลว',
    'url' => 'รูปแบบ :attribute ไม่ถูกต้อง',
    'uuid' => ':attribute ต้องเป็น UUID ที่ถูกต้อง',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
