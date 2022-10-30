
/**
 * Parse Integer
 * 
 * @param {*} value
 * @param {*} fallback
 * 
 * @return {int|*} Integer value or fallback
 */
function parseInteger( value, fallback ) {

    if ( '' === value || isNaN( value ) ) {
        return fallback;
    }

    return parseInt( value );

}

export { parseInteger };