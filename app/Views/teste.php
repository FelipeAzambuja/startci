<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>

    </head>
    <body>

        <input type="text" ds=""

        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        function Dataset(id) {
            this.ds_id = id;

            this.data = [];
            this.total_rows = 0;
            this.buffer = 0;
            this.row = {};
            this.cols = [];


            this.move_first = function () {

            };
            this.move_last = function () {

            };
            this.move_next = function () {

            };
            this.move_previous = function () {

            };
            this.move = function (n) {

            };
            this.refresh = function () {
                $.post('/Datasets/' + this.ds_id + '/refresh').then((response) => {
                    debugger;
                }).fail((response) => {
                    debugger;
                });
            };
            this.init = function () {
                this.refresh();
                this.move_first();
            };

        }

        var pessoas = new Dataset('pessoas');
        pessoas.data;
        pessoas.row.id;
        pessoas.cols;

    </script>
</body>
</html>
