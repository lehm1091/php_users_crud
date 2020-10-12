<?php
const INDEX_URL = "./index.html";
session_start();
session_destroy();
header("Location:" . INDEX_URL);
