# Final Project Grading Outline

# Data Engineering and Machine Learning

The bulk of the grading is in the following sections.

## Data Gathering and Preparation (30%):

**Data gathering/preprocessing** (may not be as relevant depending on project):

- Did you find ways of processing your data to make the problem at hand more tractible/easier

**Examples:** image formatting, string matching.

**Data integrity checks (10%):** 

- Did you account for missing values and outliers? 
- Is there information leakage? ie. a variable which is actually inferred by the outcome (eg. predicting a user likes a movie using the fact that they've liked that movie before).

**Feature Engineering (15%):** 
- Did you convert categorical features into one hot encoded dummy variables? 
- Was there an opportunity to make a new variable from the old ones that has more predictive power? (ie. if you are predicting the Titanic survivor problem and Cabin seems to be predictive but it's sparse, maybe replacing it with a binary variable "had a cabin or not" is better). 

**Standarization (5%):** 
- Did you standardize your variables properly?

## Model Selection, Comparison and Cross Validation (60%):

**Exploratory Analysis (10%):** 
- Did you analyze the features and how they are related to the outcome variable? (regression: scatter plots, classification: conditional histograms). 
- Did you look at correlations?

**Model Selection (50%)**: 
- Did you randomly split your data into training and testing data (20%, 80%)?
- Did you perform regularization (very important if the number of features is large!)? Why did you use L^1 or L^2? I expect to see use of GridSearchCV for this with at least 2 fold cross validation.
- Did you try out various models and see which one performed best? (You don't need to check all of them, but for classification/regression you should at least try Logistic (Linear) Regression and Random Forest Classification (Regression). For regression you should use R^2 as a comparison and for classification, use ROC. For recommendation systems, you should look at precision/recall. **I would like to see a performance comparison of at least two different models. **


# Design and Strategy

## Problem Statement and Usefuleness: (5%)

Is the problem clearly stated and motivated? Is this something useful or is it contrived?

## User Experience (5%):

Is the website relatively easy to use? Does it accept some kind of user input and then apply a model, and return
the user information?









 
