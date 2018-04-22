<?php

namespace NikolayS93\Auth;

add_option( Utils::get_option_name(), array() );
Plugin::set_path();
flush_rewrite_rules();
