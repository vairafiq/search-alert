function formatTimeAsCountdown( timeInSecond ) {
    return ( ! isNaN( timeInSecond ) ) ? new Date( timeInSecond * 1000).toISOString().substring(14, 19) : '00:00';
}

export { formatTimeAsCountdown }