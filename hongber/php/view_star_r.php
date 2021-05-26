<div class="view_startRadio">
    <label class="view_startRadio__box">
        <input type="radio" name="view_star" class="view_star_input" value="0.5">
        <span class="view_startRadio__img"><span class="blind">별 0.5개</span></span>
    </label>
    <label class="view_startRadio__box">
        <input type="radio" name="view_star" class="view_star_input" value="1">
        <span class="view_startRadio__img"><span class="blind">별 1개</span></span>
    </label>
    <label class="view_startRadio__box">
        <input type="radio" name="view_star" class="view_star_input" value="1.5">
        <span class="view_startRadio__img"><span class="blind">별 1.5개</span></span>
    </label>
    <label class="view_startRadio__box">
        <input type="radio" name="view_star" class="view_star_input" value="2">
        <span class="view_startRadio__img"><span class="blind">별 2개</span></span>
    </label>
    <label class="view_startRadio__box">
        <input type="radio" name="view_star" class="view_star_input" value="2.5">
        <span class="view_startRadio__img"><span class="blind">별 2.5개</span></span>
    </label>
    <label class="view_startRadio__box">
        <input type="radio" name="view_star" class="view_star_input" value="3">
        <span class="view_startRadio__img"><span class="blind">별 3개</span></span>
    </label>
    <label class="view_startRadio__box">
        <input type="radio" name="view_star" class="view_star_input" value="3.5">
        <span class="view_startRadio__img"><span class="blind">별 3.5개</span></span>
    </label>
    <label class="view_startRadio__box">
        <input type="radio" name="view_star" class="view_star_input" value="4">
        <span class="view_startRadio__img"><span class="blind">별 4개</span></span>
    </label>
    <label class="view_startRadio__box">
        <input type="radio" name="view_star" class="view_star_input" value="4.5">
        <span class="view_startRadio__img"><span class="blind">별 4.5개</span></span>
    </label>
    <label class="view_startRadio__box">
        <input type="radio" name="view_star" class="view_star_input" value="5">
        <span class="view_startRadio__img"><span class="blind">별 5개</span></span>
    </label>
</div>
<p class="view_star_score">
<?php
echo ($star_avg / 2) . '점(' . $star_count . '명의 평가)';
?>
</p>