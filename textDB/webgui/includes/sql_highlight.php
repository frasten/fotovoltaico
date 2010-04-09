<?php

    /*
        Function: highlight_sql
        Author: ME Wieringa <pholeron@hotmail.com>
        Edited: PA Canals y Trocha <contact@p-act.net>
        
        Description: Highlight your query on the fly
    */
    function highlight_sql($string)
    {
        $aKeywords = array(); 

        // keyword name (any string [a-zA-Z0-9_], or any character), keyword to next line (true or false, default: false), css class (default: 'keyword')

        // SQL syntax
        $aKeywords[] = array('add', false);
        $aKeywords[] = array('alter', true);
        $aKeywords[] = array('and', false);
        $aKeywords[] = array('as', false);
        $aKeywords[] = array('asc', false);
        $aKeywords[] = array('by', false);
        $aKeywords[] = array('change', false);
        $aKeywords[] = array('column', false);
        $aKeywords[] = array('create', true);
        $aKeywords[] = array('database', false);
        $aKeywords[] = array('default', false);
        $aKeywords[] = array('delete', false);
        $aKeywords[] = array('desc', false);
        $aKeywords[] = array('distinct', false);
        $aKeywords[] = array('drop', false);
        $aKeywords[] = array('from', false);
        $aKeywords[] = array('having', true);
        $aKeywords[] = array('group', true);
        $aKeywords[] = array('insert', true);
        $aKeywords[] = array('in', true);
        $aKeywords[] = array('into', false);
        $aKeywords[] = array('join', false);
        $aKeywords[] = array('left', false);
        $aKeywords[] = array('like', false);
        $aKeywords[] = array('limit', false);
        $aKeywords[] = array('list', true);
        $aKeywords[] = array('modify', false);
        $aKeywords[] = array('order', true);
        $aKeywords[] = array('on', false);
        $aKeywords[] = array('or', false);
        $aKeywords[] = array('rand', false);
        $aKeywords[] = array('right', false);
        $aKeywords[] = array('select', true);
        $aKeywords[] = array('set', false);
        $aKeywords[] = array('table', false);
        $aKeywords[] = array('update', true);
        $aKeywords[] = array('values', false);
        $aKeywords[] = array('where', false);


		// SQL functions
		$aKeywords[] = array('ABS', false, 'function');
		$aKeywords[] = array('EVAL', false, 'function');
		$aKeywords[] = array('LAST_INSERT_ID', false, 'function');
		$aKeywords[] = array('LCASE', false, 'function');
		$aKeywords[] = array('LOWER', false, 'function');
		$aKeywords[] = array('MD5', false, 'function');
		$aKeywords[] = array('NOW', false, 'function');
		$aKeywords[] = array('UNIX_TIMESTAMP', false, 'function');
		$aKeywords[] = array('UCASE', false, 'function');
		$aKeywords[] = array('UPPER', false, 'function');


        // Operators
        $aKeywords[] = array('+', false, 'operator');
        $aKeywords[] = array('-', false, 'operator');
        $aKeywords[] = array('*', false, 'operator');
        $aKeywords[] = array('/', false, 'operator');
        $aKeywords[] = array('=', false, 'operator');
        $aKeywords[] = array('<', false, 'operator');
        $aKeywords[] = array('>', false, 'operator');
        $aKeywords[] = array('%', false, 'operator');
        $aKeywords[] = array('.', false, 'operator');
        $aKeywords[] = array(',', false, 'operator');
        $aKeywords[] = array(';', false, 'operator');


        // Boolean operators
        $aKeywords[] = array('true', false, 'quoted');
        $aKeywords[] = array('false', false, 'quoted');
        $aKeywords[] = array('null', false, 'quoted');
        $aKeywords[] = array('unkown', false, 'quoted');


        // Split query into pieces (quoted values, ticked values, string and/or numeric values, and all others).
        $expr = '/(\'((\\\\.)|[^\\\\\\\'])*\')|(\`((\\\\.)|[^\\\\\\\`])*\`)|([a-z0-9_]+)|([\s\n]+)|(.)/i';
        preg_match_all($expr, $string, $matches);

        // Use a buffer to build up lines.
        $buffer = '';
        
        // Keep track of brackets to indent/outdent
        $iTab = 0;

        for($i = 0; $i < sizeof($matches[0]); $i++)
        {
            if(strcasecmp($match = $matches[0][$i], "") !== 0)
            {
                if(in_array($match, array("(", ")"))) // Bracket found
                {
                    $buffer = trim($buffer);

                    if(strlen($buffer) > 0)
                    {
                        $result .= $buffer . '<br>';
                    }

                    $buffer = '';

                    if(strcasecmp($match, ")") === 0)
                    {
                        $iTab--;

                        if($iTab < 0)
                        {
                            $iTab = 0;
                        }

                        $result .= str_repeat('&nbsp;', 4 * $iTab) . '<span class="bracket">' . mb_convert_encoding($match,"HTML-ENTITIES","utf-8, iso-8859-1") . '</span><br>';
                    }
                    else // if(strcasecmp($match, "(") === 0)
                    {
                        $result .= str_repeat('&nbsp;', 4 * $iTab) . '<span class="bracket">' . mb_convert_encoding($match,"HTML-ENTITIES","utf-8, iso-8859-1") . '</span><br>';
                        $iTab++;
                    }
                }
                elseif(preg_match('/^[\s\n]+$/', $match)) // Space character(s)
                {
                    if(strlen($buffer) === 0)
                    {
                        // Ignore space character(s)!
                    }
                    else
                    {
                        $buffer .= ' ';
                    }
                }
                else
                {
                    $aKeyword = false;

                    for($j = 0; $j < sizeof($aKeywords); $j++)
                    {
                        if(strcasecmp($match, $aKeywords[$j][0]) === 0)
                        {
                            $aKeyword = $aKeywords[$j];
                            break;
                        }
                    }

                    if($aKeyword) // Keyword found
                    {
                        if(isset($aKeyword[1]) && $aKeyword[1] === true) // Keyword to next line
                        {
                            $buffer = trim($buffer);

                            if(strlen($buffer) > 0)
                            {
                                $result .= $buffer . '<br>';
                            }

                            $buffer = ''; 
                        }

                        if(strlen($buffer) === 0) // Indent
                        {
                            $buffer .= str_repeat('&nbsp;', 4 * $iTab); 
                        }

                        $buffer .= '<span class="' . (isset($aKeyword[2]) ? $aKeyword[2] : 'keyword') . '">' . mb_convert_encoding(strtoupper($match),"HTML-ENTITIES","utf-8, iso-8859-1") . '</span>';
                    }
                    else
                    {
                        if(strlen($buffer) === 0) // Indent
                        {
                            $buffer = str_repeat('&nbsp;', 4 * $iTab);
                        }

                        if((strcasecmp(substr($match, 0, 1), "'") === 0) || is_numeric($match)) // Quoted value or number
                        {
                            $buffer .= '<span class="quoted">' . mb_convert_encoding($match,"HTML-ENTITIES","utf-8, iso-8859-1") . '</span>';
                        }
                        elseif((strcasecmp(substr($match, 0, 1), "`") === 0) || preg_match('/[a-z0-9_]+/i', $match)) // Ticked value or unquoted string (table/column name?!)
                        {
                            $buffer .= '<span class="ticked">' . mb_convert_encoding($match,"HTML-ENTITIES","utf-8, iso-8859-1") . '</span>';
                        }
                        else // All other chars
                        {
                            $buffer .= mb_convert_encoding($match,"HTML-ENTITIES","utf-8, iso-8859-1");
                        }
                    }
                }
            }
        }

        $buffer = trim($buffer);

        if(strlen($buffer) > 0)
        {
            $result .= $buffer;
        }

        return '<code class="sql">' . $result . '</code>';
    }


    /*
        Function: stripped_highlight_sql
        Author: PA Canals y Trocha <contact@p-act.net>
        
        Description: Strip Highlight to fit on one line
    */
    function stripped_highlight_sql($string)
    {
        $result = highlight_sql($string);

        $result = str_replace('<br>', '', $result);
        $result = str_replace('&nbsp;', '', $result);

        return $result;
    }

?>