const calendarDates = document.getElementById("calendarDates");
const currentMonthElement = document.getElementById("currentMonth");

const today = new Date(); // 현재 날짜를 나타내는 Date 객체를 저장
let currentMonth = today.getMonth();
let currentYear = today.getFullYear(); 

function makeCalendar() {

  const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
  const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
  const startDayOfWeek = firstDayOfMonth.getDay();
  currentMonthElement.textContent = `${currentYear}년 ${currentMonth + 1}월`;
  calendarDates.innerHTML = "";

  // 빈 날짜(이전 달)
  for (let i = 0; i < startDayOfWeek; i++) {
    const emptyDate = document.createElement("div");
    //  빈 날짜를 나타내는 div 요소를 생성
    emptyDate.classList.add("date", "empty");
    // 생성한 div 요소에 "date"와 "empty" 클래스를 추가
    calendarDates.appendChild(emptyDate);
    // 생성한 빈 날짜 요소를 캘린더 그리드에 추가
  }

  // 현재 달의 날짜
  for (let i = 1; i <= daysInMonth; i++) {
    const dateElement = document.createElement("div");
    dateElement.classList.add("date");
    dateElement.textContent = i;
    dateElement.addEventListener("click", function() {
      const selectedDate = `${currentYear}-${(currentMonth + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;
      window.location.href = `date_detail.php?date=${selectedDate}`;
    });
    calendarDates.appendChild(dateElement);
  }
}

makeCalendar();