# WEB-TRINITY
### An Interactive Web-Based Coursework for Website Development 1

**Project Type:** Developmental Research / Web Application Prototype  
**Target Institution:** CIE  
**Target Participants:** Second-Year Computer Programming Students  
**Primary Subject:** Website Development 1  
**Development Stack:** HTML, CSS, JavaScript, PHP, MySQL  
**Current Development Goal:** Functional research prototype demonstrating the core learning experience

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Background and Problem Statement](#2-background-and-problem-statement)
3. [Target Participants and Stakeholders](#3-target-participants-and-stakeholders)
4. [Project Objectives](#4-project-objectives)
5. [Proposed Solution](#5-proposed-solution)
6. [Scope and Limitations](#6-scope-and-limitations)
7. [Core Features and Functional Requirements](#7-core-features-and-functional-requirements)
8. [Learning Design and Instructional Approach](#8-learning-design-and-instructional-approach)
9. [Technology Stack](#9-technology-stack)
10. [System Architecture](#10-system-architecture)
11. [Project Folder Structure](#11-project-folder-structure)
12. [Database Design](#12-database-design)
13. [Core Application Workflows](#13-core-application-workflows)
14. [Development Environment Setup](#14-development-environment-setup)
15. [Development Roadmap](#15-development-roadmap)
16. [Coding Standards and Best Practices](#16-coding-standards-and-best-practices)
17. [Security Requirements](#17-security-requirements)
18. [Testing and Acceptance Criteria](#18-testing-and-acceptance-criteria)
19. [Research Evaluation Considerations](#19-research-evaluation-considerations)
20. [Version Control and Git Workflow](#20-version-control-and-git-workflow)
21. [Known Limitations](#21-known-limitations)
22. [Future Enhancements](#22-future-enhancements)
23. [Definition of Done](#23-definition-of-done)

---

# 1. Project Overview

WEB-TRINITY is a proposed interactive web-based coursework platform designed to support the teaching and learning of Website Development 1 among second-year Computer Programming students at CIE.

The platform focuses on three foundational frontend technologies:

- **HTML (HyperText Markup Language):** Defines the structure and content of a webpage.
- **CSS (Cascading Style Sheets):** Controls the presentation, styling, and layout of a webpage.
- **JavaScript:** Adds behavior, interactivity, and dynamic functionality to a webpage.

Rather than relying exclusively on static instructional materials, WEB-TRINITY aims to combine instructional content, guided coding activities, live webpage previews, formative feedback, and student progress tracking in one learning environment.

The intended learning experience follows a practical sequence:

**Learn a concept → Examine an example → Write code → Observe the result → Receive feedback → Improve the solution → Track progress.**

The prototype will demonstrate this experience through a limited number of reference modules and two connected coding lessons. The complete coursework and additional system capabilities may be developed after the prototype has been tested and evaluated.

## Project Vision

To provide a structured, interactive, and practice-oriented learning environment where students can understand frontend development concepts and apply them by building small, functional webpage components.

## Guiding Principle

WEB-TRINITY should prioritize meaningful learning activities over the number of features implemented.

A small number of working lessons that demonstrate the complete learning process is more valuable for this prototype than a large collection of incomplete pages.

---

# 2. Background and Problem Statement

## 2.1 Background

Website Development 1 introduces students to foundational concepts and practical skills required to create websites. Learning frontend development involves understanding syntax, relationships between HTML and CSS, JavaScript behavior, and the way these technologies work together in a browser.

Students need opportunities to move beyond reading explanations and observing demonstrations. They also need to practice writing code, examining the rendered output, identifying mistakes, and revising their solutions.

A web-based coursework platform may help organize these learning activities into a structured environment. By combining learning materials, coding exercises, live previews, and progress records, WEB-TRINITY intends to support a more continuous relationship between instruction and practical application.

## 2.2 Problem Statement

The research will investigate the need for an interactive web-based coursework platform for Website Development 1 among second-year Computer Programming students at CIE.

The development initiative is motivated by the following instructional concerns, which must be verified and refined using the researcher's actual observations, literature review, and consultation with the subject instructor:

1. **Separation of instructional materials and coding practice.** When explanations, examples, exercises, and feedback are distributed across different resources, students may need to switch between environments while completing learning activities.

2. **Limited opportunities for immediate experimentation.** Students benefit from being able to modify code and observe its effect on a webpage while learning. The extent to which existing instructional arrangements provide this opportunity needs to be established.

3. **Difficulty identifying and correcting errors.** Beginners may struggle to determine why their code does not produce the expected output. Structured hints and formative feedback may help them identify areas for improvement.

4. **Need for organized practical progression.** Students learning HTML, CSS, and JavaScript need an appropriate sequence of activities that builds foundational knowledge before combining concepts into more complex webpage components.

5. **Need to monitor coursework progress.** A centralized progress record may help students monitor completed activities and help instructors review students' participation and performance.

These concerns serve as the initial rationale for developing WEB-TRINITY. They should not be treated as established findings until supported by research evidence.

## 2.3 Proposed Response

WEB-TRINITY will address these concerns by providing:

- Organized HTML, CSS, and JavaScript reference modules.
- Sequential, guided coding lessons.
- An embedded code editor and live webpage preview.
- Basic formative feedback and hints.
- Saved activity attempts and lesson completion records.
- A student dashboard displaying learning progress.
- A basic teacher view for monitoring student completion and results.

The system is intended to support existing instruction, not replace the instructor or the institution's official learning management and assessment processes.

---

# 3. Target Participants and Stakeholders

## 3.1 Primary Target Participants

**Second-Year Computer Programming Students at CIE**

The intended student users are learners taking Website Development 1 who need to develop foundational skills in HTML, CSS, and JavaScript.

The coursework should be designed with beginner and developing programmers in mind. Instructions should be clear, examples should be manageable, and coding activities should gradually increase in complexity.

### Intended student needs

- Understand foundational frontend concepts.
- Access instructional references while working on activities.
- Practice coding without repeatedly switching between tools.
- Observe the result of their code changes.
- Receive understandable feedback when their work does not meet an activity's requirements.
- Review completed lessons and monitor progress.

These are design assumptions to validate during research and evaluation, not claims that every target student has the same needs or difficulties.

## 3.2 Secondary Stakeholders

### Website Development 1 Instructor

The instructor may use the platform to:

- Review and organize coursework content.
- Guide students through practical lessons.
- Monitor saved completion and activity records.
- Identify activities where students may need additional support.

### Researchers and Developers

The researchers will design, implement, test, document, and refine the prototype. They will also prepare the system for evaluation and record its limitations.

### Evaluators and Validators

Depending on the approved research methodology, evaluators may examine the software's functionality, usability, reliability, instructional content, and other relevant quality characteristics.

The exact participants, sample size, instruments, and evaluation procedures must follow the approved research protocol.

---

# 4. Project Objectives

## 4.1 General Objective

To develop an interactive web-based coursework prototype for Website Development 1 among second-year Computer Programming students at CIE, focusing on foundational HTML, CSS, and JavaScript concepts through guided coding activities, live previews, formative feedback, and progress tracking.

## 4.2 Specific Development Objectives

The prototype aims to:

1. Organize foundational instructional materials for HTML, CSS, and JavaScript.
2. Provide guided coding activities that allow students to practice frontend development.
3. Integrate a code editor and live preview to support immediate experimentation.
4. Provide basic feedback and hints based on defined activity requirements.
5. Record student attempts and lesson completion in a database.
6. Implement prerequisite-based progression between practical lessons.
7. Display student progress through a personalized dashboard.
8. Provide a basic teacher interface for reviewing saved student progress, if time permits.
9. Evaluate the developed prototype using the criteria and methods approved for the research.

These are development objectives. The system's effectiveness in improving learning outcomes must be investigated separately and should not be assumed from the existence of the features.

---

# 5. Proposed Solution

WEB-TRINITY will combine three connected learning areas.

## 5.1 Learn: Reference Modules

Students can access foundational instructional materials organized by technology.

| Module | Example topics |
|---|---|
| HTML | Document structure, elements, attributes, links, images, buttons, forms |
| CSS | Selectors, colors, typography, spacing, box model, Flexbox, responsive styling |
| JavaScript | Variables, functions, DOM selection, event listeners, conditions, basic interaction |

Reference materials should remain accessible independently of practical lesson completion. A student should be able to review a concept even when a later coding lesson remains locked.

## 5.2 Practice: Interactive Coding Lessons

Students complete guided exercises using an embedded editor and live preview.

The initial prototype will include two connected lessons:

**Lesson 1 — Build and Style a Button**

Students create a button using HTML and apply basic CSS styling. They observe how changes to markup and styles affect the rendered result.

**Lesson 2 — Add JavaScript Behavior**

Students add JavaScript behavior to the button, such as changing its text or displaying a message when clicked.

Lesson 2 will require qualifying completion of Lesson 1.

## 5.3 Progress: Student Dashboard

The dashboard will display:

- Available and completed lessons.
- Locked lessons and their prerequisites.
- Saved progress and activity results.
- A simple completion summary.

Progress should be based on saved database records rather than temporary browser state.

## 5.4 Teacher View

If time permits, the prototype will include a teacher-only dashboard displaying student accounts, completion status, and recorded activity results.

For the two-week prototype, this view may be read-only. Full lesson authoring, advanced analytics, and complex reporting are outside the initial scope.

---

# 6. Scope and Limitations

## 6.1 Included in the Prototype

- Basic student registration, login, and logout.
- Role-based access for students and teachers.
- Foundational HTML, CSS, and JavaScript reference pages.
- Two interactive coding lessons.
- Embedded code editor.
- Live webpage preview.
- Basic instructional checking and feedback.
- Saving code drafts and activity attempts.
- Lesson completion and sequential unlocking.
- Student progress dashboard.
- Basic teacher progress view, if feasible.
- Local development and functional testing.

## 6.2 Excluded from the Initial Prototype

- A complete HTML, CSS, and JavaScript curriculum.
- Dozens of lessons and projects.
- Advanced automated assessment of arbitrary programs.
- AI-powered tutoring or code generation.
- Multiplayer coding or collaboration.
- Cloud execution of arbitrary user code.
- Complex ranking, badges, and gamification.
- Email verification and password recovery workflows.
- Advanced teacher course-authoring tools.
- Production-scale hosting and load testing.
- Native mobile applications.
- Claims of improved academic performance without supporting evaluation evidence.

## 6.3 Prototype Versus Complete Product

The prototype demonstrates the proposed system's core interactions and feasibility. It does not imply that every feature required by a complete educational platform has already been implemented.

After evaluation, the researchers may expand the lesson library, improve feedback, refine instructional design, add teacher content management, and strengthen deployment and security controls.

---

# 7. Core Features and Functional Requirements

## FR-01: User Authentication

The system shall allow registered users to log in and log out.

Passwords must be stored as secure hashes. Access to protected pages must require a valid session.

## FR-02: Role-Based Access

The system shall distinguish student and teacher accounts.

Students must not be able to access teacher-only pages or another student's private records.

## FR-03: Reference Modules

The system shall provide organized instructional content for HTML, CSS, and JavaScript.

Reference modules shall remain accessible without requiring students to complete practical lessons first.

## FR-04: Practical Lesson Access

The system shall display available practical lessons and their completion or locked status.

The server shall verify lesson prerequisites whenever a protected lesson or relevant API endpoint is requested.

## FR-05: Code Editing

The lesson workspace shall allow students to edit the starter code supplied for an activity.

The initial editor shall support HTML, CSS, and JavaScript.

## FR-06: Live Preview

The system shall render the student's code in a separate preview area.

Changes should be reflected without requiring a full application-page reload for each edit.

## FR-07: Formative Feedback

The system shall provide basic feedback based on defined activity requirements.

Feedback may include missing elements, incorrect expected text, unmet styling requirements, or hints that guide students toward a solution.

## FR-08: Activity Submission

The system shall accept activity submissions, validate them according to the lesson's defined criteria, and record the attempt.

An unsuccessful attempt shall not automatically mark a lesson as completed.

## FR-09: Draft Saving

The system shall allow students to save unfinished code separately from completed activity attempts.

A saved draft shall not automatically count as a completed lesson.

## FR-10: Lesson Progression

The system shall permit Lesson 2 access only after the required completion criteria for Lesson 1 have been met and recorded.

Lesson unlocking must be enforced on the server, not merely through hidden buttons or disabled links.

## FR-11: Progress Dashboard

The system shall display the student's saved lesson status and progress.

Progress shall persist across logout and subsequent login.

## FR-12: Teacher Progress View

If included in the prototype, authorized teachers shall be able to view student completion records and recorded results.

---

# 8. Learning Design and Instructional Approach

WEB-TRINITY will use a structured, practice-oriented learning sequence.

## 8.1 Proposed Learning Cycle

1. **Introduce:** Explain the concept and learning objective.
2. **Demonstrate:** Show a working code example.
3. **Practice:** Allow the student to edit or complete code.
4. **Observe:** Display the rendered output or interactive behavior.
5. **Check:** Compare the submission against defined requirements.
6. **Improve:** Provide hints and allow another attempt.
7. **Record:** Save the attempt and qualifying completion status.

## 8.2 Progressive Learning

The prototype will introduce a manageable concept before combining it with previous concepts.

For example:

- Lesson 1 focuses on HTML structure and CSS styling.
- Lesson 2 reuses the button and introduces JavaScript event handling.

This provides an initial example of progressive integration across the three frontend technologies.

## 8.3 Formative Feedback

Feedback should explain what the student needs to improve rather than only displaying a score.

Example:

- **Unmet requirement:** The button does not display the expected text.
- **Hint:** Review the text between the opening and closing button tags.
- **Next step:** Correct the text and submit the activity again.

For the prototype, feedback rules may be simple and predefined. They should be understandable, consistent, and aligned with the lesson objectives.

## 8.4 Assessment Principle

The prototype's automated checks are instructional aids, not a substitute for comprehensive evaluation of programming competence.

A solution can be valid even when its code differs from the reference solution. Checks should therefore focus on the intended learning requirements rather than unnecessarily requiring identical code.

---

# 9. Technology Stack

The prototype will use technologies already relevant
