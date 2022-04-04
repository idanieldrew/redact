<?php

namespace Module\Share\Repository;

interface Repository
{
    public function paginate($number = 10);

    public function show($search);

    public function destroy($model);
}