<?php
/**
 * strpos的实现 时间复杂度O(m*n)
 */
function my_strpos($haystack,$needle,$offset = 0){
	
	if (!is_string($haystack) || !is_string($needle) || !is_int($offset)) {
		return NULL;
	}

	$haystack_len = strlen($haystack);
	$needle_len = strlen($needle);

	if ($offset < 0 || ($needle_len + $offset > $haystack_len)) {
		return FALSE;
	}

	for (; $offset <= $haystack_len - $needle_len ; $offset++) { 
		$tmp = $offset;
		$find_num = 0;
		while ($find_num < $needle_len) {
			if ($haystack[$tmp] == $needle[$find_num]) {
				$tmp++;
				$find_num++;
			}else{
				break;
			}
		}
		if ($find_num >= $needle_len) {
			return $offset; 
		}
	}
	return FALSE;
}

/**
 * strpos的KMP实现 时间复杂度O(m+n)
 */
function kmp_strpos($haystack,$needle,$offset){
}










