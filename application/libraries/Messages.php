<?php
/**
 * @name		CodeIgniter Message Library
 * @author		Jens Segers
 * @link		http://www.jenssegers.be
 * @license		MIT License Copyright (c) 2012 Jens Segers
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Messages {
    private $ci;
    
    function __construct($params = array()) {
        $this->ci = & get_instance();
        $this->ci->load->library('session');
    }
    
    function clear($type = null) {
        if (!empty($type)) {
            $messages = $this->ci->session->userdata('messages');
            if (!is_array($messages)) {
                $messages = array();
            }
            
            if (array_key_exists($type, $messages)) {
                unset($messages[$type]);
            }
            
            $this->ci->session->set_userdata('messages', $messages);
        } else {
            $this->ci->session->set_userdata('messages', array());
        }
    }
    
    function add($message, $type = 'message') {
        $messages = $this->ci->session->userdata('messages');
        if (!is_array($messages)) {
            $messages = array();
        }
        
        if (is_a($message, 'Exception')) {
            $message = $message->getMessage();
            $type = 'error';
        }
        
        if ((!isset($messages[$type]) || !in_array($message, $messages[$type])) && is_string($message) && $message) {
            $messages[$type][] = $message;
        }
        
        $this->ci->session->set_userdata('messages', $messages);
    }
    
    function count($type = null) {
        $messages = $this->ci->session->userdata('messages');
        if (!is_array($messages)) {
            $messages = array();
        }
        
        if (!empty($type)) {
            if (array_key_exists($type, $messages)) {
                return count($messages[$type]);
            } else {
                return 0;
            }
        }
        
        $i = 0;
        foreach ($messages as $type => $m) {
            $i += count($messages[$type]);
        }
        return $i;
    }
    
    function get($type = null) {
        $messages = $this->ci->session->userdata('messages');
        if (!is_array($messages)) {
            $messages = array();
        }
        
        if (!empty($type)) {
            if (array_key_exists($type, $messages)) {
                $messages = $messages[$type];
                $this->clear($type);
                return $messages;
            } else {
                return array();
            }
        }
        
        $this->clear();
        return $messages;
    }
}  