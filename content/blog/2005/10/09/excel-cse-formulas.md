---
categories: [computer]
date: 2005-10-09T02:00:46-04:00
guid: 'http://cosmicosmo.ath.cx/log/2005/10/09/excel-cse-formulas/'
id: 70
modified: 2005-11-26T06:34:30-04:00
name: excel-cse-formulas
---

Excel: CSE formulas
===================

I found a strange and for some reason hard to access feature of excel.  Functions such as 'sumif()' allow you to sum one column based on the content of itself or another.  But some very desirable formulas are too complicated for sumif(). 

One possibility is multiple condition columns.  Typing "=sum(if(a1:a100='Red',if(b1:b100='June',1,0),0)" should be a good formula to count all flowers that are red and bloom in june in the proper table.  It should sum the range the results of the first if, which will be 1 if both ifs are true, or 0 otherwise.  But excel doesn't understand this, and can't normally handle ranges in non-ranged functions.

Another example, which I discovered this by (something like the above is the example I found that allowed me to figure this out, thanks http://www.mrexcel.com/tip011.shtml ), is to sum the totals of only negative numbers in a column.  I wanted to do this for a worksheet I have monitoring the amount of gas I have used from my propane tank.  One column has use, which is negative if it was filled.  I wanted to sum all fills.  Sumif() didn't work at all, so I tried (based on Mr. Excel's example) to put "=sum(if(a1:a100<0,a1:a100,0))", but that didn't work either.

The solution to allowing Excel to handle ranges in regular functions is simply to hit control-shift-enter after entering them.  Suddenly, they work properly.  The formula then has curly brackets around it in the formula bar.  Every time the formula is changed, you must hit control-shift-enter.  If you hit regular enter, it will revert back to a non-functioning function.  You must click on the formula in the formula bar to get this to work again.

I don't know why Excel hides this functionality behind a rather unknown and unusual key combination.  The functions are worthless otherwise, so there is no reason to have the non-CSE functionality when entering these functions.   They add a great amount of power to the analysis of data, allowing many of the possibilities that otherwise only real databases would allow.
