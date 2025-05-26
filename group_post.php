<html>
<head>
    <title>소모임</title>
</head>
<body>
    <form method="POST" action="group.php">
        지역 : <select name="region_id">
        <option value="1">서울</option>
        <option value="2">인천</option>
        <option value="3">경기</option>
        <option value="4">대전</option>
        <option value="5">세종</option>
        <option value="6">충북</option>
        <option value="7">충남</option>
        <option value="8">부산</option>
        <option value="9">대구</option>
        <option value="10">울산</option>
        <option value="11">경북</option>
        <option value="12">경남</option>
        <option value="13">광주</option>
        <option value="14">전북</option>
        <option value="15">전남</option>
        </select><br/>

        분야 : <select name="group_category_id">
        <option value="1">운동</option>
        <option value="2">자기계발</option>
        <option value="3">동네 친구</option>
        <option value="4">아웃도어/여행</option>
        <option value="5">가족/육아</option>
        <option value="6">반려 동물</option>
        <option value="7">음식/음료</option>
        <option value="8">취미/오락</option>
        <option value="9">문화/예술</option>
        <option value="10">기타</option>
        </select><br/>

        요일 : <select name="week">
        <option value="1">월요일</option>
        <option value="2">화요일</option>
        <option value="3">수요일</option>
        <option value="4">목요일</option>
        <option value="5">금요일</option>
        </select><br/>

        시작 시간: <input type="datetime-local" name="start_time"><br/>
        종료 시간: <input type="datetime-local" name="end_time"><br/>

        회비 : 월 <input type="int" name="price"/> 원 <br/>
        정원 : <input type="int" name="participants"/> 명 <br/>

        모임명 : <input type="text" name="title"/><br/>
        모집 글 : <input type="text" name="content"/><br/>
        
        모집 상태 : <select name="status">
        <option value="1">모집 중</option>
        <option value="0">모집 마감</option>
        </select><br/>
        <input type="submit" name="소모임 만들기"/>
    </form>

</body>
</html>